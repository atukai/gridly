<?php

namespace Gridly\Source;

use Gridly\Schema\Order\Order;
use Gridly\Schema\Schema;
use Gridly\Schema\Filter\Exception;
use Gridly\Schema\Filter\Filter;
use Gridly\Schema\Filter\FilterSet;
use Laminas\Db\Adapter\Adapter;

class LaminasDbAdapter implements Source
{
    private Adapter $adapter;
    private string $tableName;
    private string $baseQuery;
    private string $query;
    private array $queryParams;
    private Schema $schema;
    
    public function __construct(Adapter $adapter, string $tableName, array $columnNames = [])
    {
        $this->adapter = $adapter;
        $this->tableName = '`' . str_replace('`', '``', $tableName) . '`';
        $this->baseQuery = 'SELECT ' . implode(', ', $columnNames)  .' FROM ' . $this->tableName;
        $this->query = $this->baseQuery;
        $this->queryParams = [];
    }
    
    /**
     * @throws Exception
     */
    public function applySchema(Schema $schema): void
    {
        $this->schema = $schema;
        $this->query = $this->baseQuery;
        
        $this->filter($schema->getFilters());
        $this->sort($schema->getOrder());
    }
    
    public function getSchemaParams(): array
    {
        return $this->schema->toArray();
    }
    
    public function getItems(int $offset, int $limit): iterable
    {
        $query = $this->query;
        $query .= ' LIMIT ' . $offset . ', ' . $limit;

        return $this->adapter->query($query)->execute($this->queryParams);
    }
    
    public function count(): int
    {
        return count($this->adapter->query($this->query)->execute($this->queryParams));
    }
    
    public function countAll(): int
    {
        $query = 'SELECT COUNT(*) as cnt FROM ' . $this->tableName;
        $stm = $this->adapter->query($query)->execute();
        $result = $stm->current();
        
        return $result['cnt'];
    }
    
    /**
     * @param FilterSet $filters
     * @return void
     * @throws Exception
     */
    private function filter(FilterSet $filters): void
    {
        if ($filters->isEmpty()) {
            return;
        }
        
        $this->query .= ' WHERE ';
        
        $filtersAmount = $filters->count();
        $lastFilterIndex = $filtersAmount - 1;
        
        foreach ($filters as $i => $filter) {
            switch ($filter->getOperand()) {
                case Filter::OP_EQUAL:
                    $this->query .= $filter->getColumnName() . ' = ?';
                    $this->queryParams[] = $filter->getValue();
                    break;
                
                case Filter::OP_NOT_EQUAL:
                    $this->query .= $filter->getColumnName() . ' != ?';
                    $this->queryParams[] = $filter->getValue();
                    break;
                
                case Filter::OP_GREATER:
                    $this->query .= $filter->getColumnName() . ' > ?';
                    $this->queryParams[] = $filter->getValue();
                    break;
                
                case Filter::OP_LESS:
                    $this->query .= $filter->getColumnName() . ' < ?';
                    $this->queryParams[] = $filter->getValue();
                    break;
                
                case Filter::OP_LIKE:
                    $this->query .= $filter->getColumnName() . ' LIKE ?';
                    $this->queryParams[] = '%' . $filter->getValue() . '%';
                    break;
                
                default:
                    throw Exception::unsupportedFilterOperand($filter->getOperand(), self::class);
            }
            
            if ($filtersAmount > 1 && $i !== $lastFilterIndex) {
                $this->query .= ' AND ';
            }
        }
    }
    
    private function sort(?Order $order = null): void
    {
        if (!$order) {
            return;
        }
        
        $this->query .= ' ORDER BY ' . $order->getColumnName() . ' ' . $order->getDirection();
    }
}
