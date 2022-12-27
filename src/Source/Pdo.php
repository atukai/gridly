<?php

namespace Gridly\Source;

use Gridly\Schema;
use Gridly\Schema\Filter\Filter;
use Gridly\Schema\Filter\Exception;
use Gridly\Schema\Filter\FilterSet;
use Gridly\Schema\Order\Order;
use PDOStatement;

class Pdo implements Source
{
    private \PDO $pdo;
    private string $tableName;
    private string $query;
    private array $queryParams;
    private Schema\Schema $schema;
    
    public function __construct(\PDO $pdo, string $tableName)
    {
        $this->pdo = $pdo;
        $this->tableName = '`' . str_replace('`', '``', $tableName) . '`';
        $this->query = 'SELECT * FROM ' . $this->tableName;
        $this->queryParams = [];
    }
    
    /**
     * @throws Exception
     */
    public function applySchema(Schema\Schema $schema): void
    {
        $this->schema = $schema;
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
        
        $limitStatement = ' LIMIT ';
        $limitStatement .= $offset . ', ' . $limit;

        $query .= $limitStatement;

        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->queryParams);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function count(): int
    {
        $stm = $this->pdo->prepare($this->query);
        $stm->execute($this->queryParams);
        
        return count($stm->fetchAll());
    }
    
    public function countAll(): int
    {
        $query = 'SELECT COUNT(*) FROM ' . $this->tableName;
        return $this->pdo->query($query)->fetchColumn();
    }
    
    /**
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
