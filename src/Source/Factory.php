<?php

namespace Gridly\Source;

use Doctrine\ORM\EntityManagerInterface;
use Gridly\Schema\Schema;
use Laminas\Db\Adapter\Adapter;

class Factory
{
    public static function pdo(array $config, Schema $schema): Source
    {
        $source = new Pdo(
            new \PDO($config['source']['dsn'], $config['source']['username'], $config['source']['password']),
            $config['source']['table']
        );
        $source->applySchema($schema);

        return $source;
    }

    public static function laminasDb(array $config, Schema $schema, Adapter $adapter): Source
    {
        $source = new LaminasDbAdapter($adapter, $config['source']['table'], self::getColumnNames($config));
        $source->applySchema($schema);

        return $source;
    }

    public static function doctrine(array $config, Schema $schema, EntityManagerInterface $entityManager): Source
    {
        $source = new Doctrine($entityManager, $config['source']['entityClass'], self::getColumnNames($config));
        $source->applySchema($schema);

        return $source;
    }

    private static function getColumnNames(array $config): array
    {
        $columnNames = [];
        foreach ($config['columns'] as $name => $data) {
            $columnNames[] = $name;
        }

        return $columnNames;
    }
}
