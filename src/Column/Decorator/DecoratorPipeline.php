<?php

namespace Gridly\Column\Decorator;

use Gridly\Column\Column;
use SplQueue;

class DecoratorPipeline implements Decorator
{
    private SplQueue $queue;

    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    public function pipe(callable $decorator): DecoratorPipeline
    {
        $pipeline = clone $this;
        $pipeline->queue->enqueue($decorator);
        return $pipeline;
    }

    public function __invoke(Column $column, array $additionalData = []): Column
    {
        foreach ($this->queue as $decorator) {
            $column = $decorator($column, $additionalData);
        }
        return $column;
    }
}