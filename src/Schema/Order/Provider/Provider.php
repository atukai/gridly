<?php

namespace Gridly\Schema\Order\Provider;
use Gridly\Schema\Order\Order;

interface Provider
{
    public function provide(): ?Order;
}
