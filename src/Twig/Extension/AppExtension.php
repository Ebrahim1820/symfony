<?php

namespace App\Twig\Extension;


use App\Service\MarkdownHelper;
use App\Twig\Runtime\AppExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
;

class AppExtension extends AbstractExtension

{   

    // private $helper;
    // public function __construct(MarkdownHelper $helper)
    // {
    //     $this->helper = $helper;

    // }    
public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('cached_markdown', [$this, 'processMarkdown'],['is_safe' => ['html']]),
        ];
    }

    public function processMarkdown($value){
        // $this->helper->parse
        return strtoupper($value) ;
    }

}
