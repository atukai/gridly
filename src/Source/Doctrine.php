<?php

namespace Gridly\Source;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Gridly\Schema\Filter\Exception;
use Gridly\Schema\Filter\Filter;
use Gridly\Schema\Filter\FilterSet;
use Gridly\Schema\Order\Order;
use Gridly\Schema\Schema;

class Doctrine implements Source
{
    private const ENTITY_ALIAS = 'entity';
    
    private QueryBuilder $baseQueryBuilder;
    private QueryBuilder $queryBuilder;
    private Schema $schema;
    private array $queryParams;
    
    public function __construct(EntityManagerInterface $entityManager, string $className, array $columnNames = [])
    {
        $prefixedColumnNames = [];
        foreach ($columnNames as $name) {
            $prefixedColumnNames[] = self::ENTITY_ALIAS . '.' . $name;
        }
        
        $this->baseQueryBuilder = $entityManager->createQueryBuilder();
        $this->baseQueryBuilder->select($prefixedColumnNames)->from($className, self::ENTITY_ALIAS);
        $this->queryBuilder = clone $this->baseQueryBuilder;
        $this->queryParams = [];
    }
    
    /**
     * @throws Exception
     */
    public function applySchema(Schema $schema): void
    {
        $this->queryBuilder = clone $this->baseQueryBuilder;
        $this->schema = $schema;
        
        $this->filter($schema->getFilters());
        $this->sort($schema->getOrder());
    }
    
    public function getSchema(): Schema
    {
        return $this->schema;
    }
    
    /**
     * @param FilterSet $filters
     * @return Source
     * @throws Exception
     */
    public function filter(FilterSet $filters): Source
    {
        if ($filters->isEmpty()) {
            return $this;
        }
        
        foreach ($filters as $i => $filter) {
            switch ($filter->getOperand()) {
                case Filter::OP_EQUAL:
                    $this->queryBuilder->where(self::ENTITY_ALIAS . '.' . $filter->getColumnName() . '=?' . $i);
                    $this->queryParams[] = $filter->getValue();
                    break;
                default:
                    throw Exception::unsupportedFilterOperand($filter->getOperand(), self::class);
            }
        }
        
        return $this;
    }
    
    public function sort(?Order $order = null): Source
    {
        if (!$order) {
            return $this;
        }
    
        $this->queryBuilder->orderBy(self::ENTITY_ALIAS . '.' . $order->getColumnName(), $order->getDirection());
        return $this;
    }
    
    public function getItems(int $offset, int $limit): iterable
    {
        foreach ($this->queryParams as $i => $value) {
            $this->queryBuilder->setParameter($i, $value);
        }
    
        $qb = clone $this->queryBuilder;
        $qb->setFirstResult($offset)
            ->setMaxResults($limit);
    
        return $qb->getQuery()->getArrayResult();
    }
    
    public function count(): int
    {
        return count($this->queryBuilder->getQuery()->getResult());
    }
    
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countAll(): int
    {
        $qb = clone $this->baseQueryBuilder;
        $qb->select('count(' . self::ENTITY_ALIAS . ')');
        
        return $qb->getQuery()->getSingleScalarResult();
    }
}
