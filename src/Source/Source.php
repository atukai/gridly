<?php

namespace Gridly\Source;

use Gridly\Schema\Schema;

interface Source
{
    /**
     * Return iterable set of items from data source
     */
    public function getItems(int $offset, int $limit): iterable;
    
    /**
     * Apply schema (filtering, ordering, etc.) to source
     */
    public function applySchema(Schema $schema): void;
    
    /**
     * Get applied schema
     */
    public function getSchema(): Schema;
    
    /**
     * Count amount of items founded after applying schema
     */
    public function count(): int;
    
    /**
     * Count total items in data source
     */
    public function countAll(): int;
}
