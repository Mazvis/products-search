<?php

namespace Mazvis\ProductsParser\Facades;

use Illuminate\Support\Facades\Facade;

class ProductsParser extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'products-parser';
    }

}