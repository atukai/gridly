<?php

namespace Dashboard;

class ResultSet implements \Countable
{
    /** @var iterable  */
    private $rawData;

    /** @var array  */
    private $rows = [];

    /**
     * @param iterable $data
     * @param array $hiddenColumns
     */
    public function __construct(iterable $data, array $hiddenColumns = [])
    {
        $this->rawData = $data;
        $this->processData($data, $hiddenColumns);
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->rows);
    }

    /**
     * @param iterable $data
     * @param array $hiddenColumns
     */
    private function processData(iterable $data, array $hiddenColumns = []): void
    {
        foreach ($data as $entry) {
            $row = [];
            foreach ($entry as $name => $value) {
                if (!in_array($name, $hiddenColumns)) {
                    $row[] = new Column($name, $value);
                }
            }

            $this->rows[] = $row;
        }
    }
}
