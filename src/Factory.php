<?php

namespace Gridly;

use Doctrine\ORM\EntityManagerInterface;
use Gridly\Column\Definition;
use Gridly\Column\Definitions;
use Gridly\Paginator\PaginatorFactory;
use Gridly\Source\Doctrine;
use Gridly\Source\Exception;
use Gridly\Source\LaminasDb;
use Gridly\Source\Pdo;
use Laminas\Db\Adapter\Adapter;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Yaml\Yaml;

class Factory
{
    /**
     * @throws Schema\Filter\Exception
     * @throws Schema\Order\Exception
     * @throws Source\Exception
     */
    public static function fromYaml(
        string $fileName,
        PaginatorFactory $paginatorFactory,
        ServerRequestInterface|null $request = null,
        Adapter|EntityManagerInterface|null $provider = null
    ): Grid {
        // CONFIG
        $config = Yaml::parseFile($fileName);
    
        // SCHEMA
        $schema = Schema\Factory::create($config, $request);
        
        // SOURCE
        if (!isset($config['source']['type'])) {
            throw Exception::sourceClassNotProvided();
        }
    
        $source = match ($config['source']['type']) {
            Pdo::class => Source\Factory::pdo($config, $schema),
            LaminasDb::class => Source\Factory::laminasDb($config, $schema, $provider),
            Doctrine::class => Source\Factory::doctrine($config, $schema, $provider),
            default => throw Exception::unsupportedSourceClass($config['type']),
        };
    
        // PAGINATOR
        $paginator = $paginatorFactory::create($source, $config['paginator']);
    
        // COLUMN DEFINITIONS
        $columnDefinitions = new Definitions();
        if (isset($config['columns'])) {
            foreach ($config['columns'] as $name => $data) {
                $columnDefinitions->add($name, Definition::fromArray($data));
            }
        }
        
        // GRID
        return new Grid($source, $columnDefinitions, $paginator);
    }
}
