<?php

namespace Dashboard\Source;

class Pdo extends AbstractSource
{
    /** @var \PDO  */
    private $pdo;

    /** @var string  */
    private $tableName;

    /**
     * @param \PDO $pdo
     * @param string $tableName
     */
    public function __construct(\PDO $pdo, string $tableName)
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }

    /**
     * @param int $offset
     * @param int $itemCountPerPage
     * @return iterable
     */
    public function getItems($offset, $itemCountPerPage): iterable
    {
        $query = 'SELECT * FROM `' . $this->tableName . '`';

        $limitStatement = 'LIMIT ';
        $limitStatement .= $offset . ', ' . $itemCountPerPage;

        $query = $query . $limitStatement;

        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $query = 'SELECT COUNT(*) FROM `' . $this->tableName . '`';
        return $this->pdo->query($query)->fetchColumn();
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults()
    {
        return $this->count();
    }

    /**
     * Returns an slice of the results.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return array|\Traversable The slice.
     */
    public function getSlice($offset, $length)
    {
        return $this->getItems($offset, $length);
    }
}
