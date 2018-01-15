<?php

namespace Gridly\Schema\Filter\Provider;

use Gridly\Schema\Filter\FilterSet;

interface Provider
{
    public function provide(): FilterSet;
}