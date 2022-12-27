<?php

namespace Gridly\Source;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Gridly\Schema;
use Gridly\Schema\Filter\Exception;
use Gridly\Schema\Filter\Filter;
use Gridly\Schema\Filter\FilterSet;

use function is_array;

class DoctrineDbal implements Source
{
    private QueryBuilder $baseQueryBuilder;
    private QueryBuilder $queryBuilder;
    private Schema\Schema $schema;

    public function __construct(Connection $dbal, string $tableName)
    {
        $this->baseQueryBuilder = $dbal->createQueryBuilder();
        $this->baseQueryBuilder->select('*')->from($tableName);
        $this->queryBuilder = clone $this->baseQueryBuilder;
    }

    /**
     * @throws Exception
     */
    public function applySchema(Schema\Schema $schema): void
    {
        $this->schema = $schema;
        $this->queryBuilder = $this->baseQueryBuilder;

        $this->filter($schema->getFilters());
        $this->sort($schema->getOrder());
    }

    public function getSchemaParams(): array
    {
        return $this->schema->toArray();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getItems(int $offset, int $limit): iterable
    {
        $this->queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $this->queryBuilder->executeQuery()->fetchAllNumeric();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function count(): int
    {
        $countQueryBuilder = clone $this->queryBuilder;
        $countQueryBuilder->select('COUNT(*)')
            ->setFirstResult(0)
            ->setMaxResults(null);

        return (int)$countQueryBuilder->executeQuery()->fetchOne();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function countAll(): int
    {
        return $this->queryBuilder->executeQuery()->rowCount();
    }

    /**
     * @throws Exception
     */
    private function filter(FilterSet $filters): void
    {
        if ($filters->isEmpty()) {
            return;
        }

        foreach ($filters as $filter) {
            switch ($filter->getOperand()) {
                case Filter::OP_EQUAL:
                    $value = $filter->getValue();
                    if (is_array($value)) {
                        $this->queryBuilder->where(
                            $this->queryBuilder->expr()->in($filter->getColumnName(), $value)
                        );
                    } else {
                        $this->queryBuilder->where(
                            $this->queryBuilder->expr()->eq($filter->getColumnName(), $value)
                        );
                    }
                    break;
                case Filter::OP_LIKE:
                    $this->queryBuilder->where(
                        $this->queryBuilder->expr()->like($filter->getColumnName(), '"%' . $filter->getValue() . '%"')
                    );

                    break;
                default:
                    throw Exception::unsupportedFilterOperand($filter->getOperand(), self::class);
            }
        }
    }

    private function sort(Schema\Order\Order $order): void
    {
        $this->queryBuilder->orderBy($order->getColumnName(), $order->getDirection());
    }
}
