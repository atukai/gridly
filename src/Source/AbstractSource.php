<?php

namespace Dashboard\Source;

use Pagerfanta\Adapter\AdapterInterface as PagerfantaAdapterInterface;
use Zend\Paginator\Adapter\AdapterInterface as ZendPaginatorAdapterInterface;

abstract class AbstractSource implements ZendPaginatorAdapterInterface, PagerfantaAdapterInterface
{
}
