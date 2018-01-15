<?php

namespace Gridly\Row\Decorator;

use Gridly\Row\Row;
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

    public function __invoke(Row $row, array $additionalData = []): Row
    {
        foreach ($this->queue as $decorator) {
            $row = $decorator($row, $additionalData);
        }
        return $row;
    }
}