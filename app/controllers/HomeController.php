<?php

use Mazvis\ProductsParser\ProductsParser;

class HomeController extends BaseController {

    public function showHome() {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $content->products = ProductsParser::getProducts();
    }
}
