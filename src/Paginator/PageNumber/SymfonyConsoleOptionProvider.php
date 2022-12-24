<?php

namespace Gridly\Paginator\PageNumber;

use Symfony\Component\Console\Input\InputInterface;

class SymfonyConsoleOptionProvider implements Provider
{
    private InputInterface $input;
    
    private ?string $optionName;
    
    public function __construct(InputInterface $input, ?string $optionName = null)
    {
        $this->input = $input;
        $this->optionName = $optionName ?? self::PAGE_KEY;
    }
    
    public function provide(): int
    {
        return $this->input->getOption($this->optionName) ? (int)$this->input->getOption($this->optionName) : self::PAGE_DEFAULT;
    }
}
