<?php

namespace Mazvis\ProductsParser\Services;

use \tidy;

class TidyService
{
    /** @var  tidy */
    protected $tidy;

    function __construct()
    {
        $this->tidy = new tidy();
    }

    /**
     * Tide the html content
     * @param $content
     * @return Tidy
     */
    public function tidyTheContent($content)
    {
        $options = array('indent' => true);
        $this->tidy->parseString($content, $options);
        $this->tidy->cleanRepair();

        return $this->tidy;
    }
}