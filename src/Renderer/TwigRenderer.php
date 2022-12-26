<?php

namespace Gridly\Renderer;

use Gridly\Column\Exception;
use Gridly\Grid;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TwigRenderer implements Renderer
{
    private Environment $twig;
    private string $template;
    
    public function __construct(Environment $twig, string $template)
    {
        $this->twig = $twig;
        $this->template = $template;
    }
    
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(Grid $grid, int $page): ?string
    {
        $data = [
            'data' => $grid->getPageItems($page),
            'totalItems' => $grid->getTotalItems(),
            'foundItems' => $grid->getFoundItems(),
            'page' => $grid->getCurrentPage(),
            'totalPages' => $grid->getTotalPages(),
            'filterParams' => $grid->getSchemaFilterParams(),
        ];
        
        return $this->twig->render($this->template, $data);
    }
}
