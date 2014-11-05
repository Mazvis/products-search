<?php

use Mazvis\ProductsParser\ProductsParser;

class HomeController extends BaseController
{
    public function showHome()
    {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $products = ProductsParser::getProducts();
        $content->products = json_decode($products);
        $content->textLikeTitle = 'Visi produktai:';
    }

    public function showByCategory($categoryName = null)
    {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $content->products = [];
        $content->textLikeTitle = 'no found';
        if ($categoryName) {
            $products = ProductsParser::getProductsByCategory($categoryName);
            $content->products = json_decode($products);
            $content->textLikeTitle = 'Kategorijos "' . $categoryName . '" prekės:';
        }
    }

    public function search()
    {
        $content = $this->layout->content;

        $keyword = Input::get('s');

        $content->products = [];
        $content->textLikeTitle = "Paieška pagal: '" . $keyword . "': ";
        $products = ProductsParser::doSearch($keyword);

        $this->products = json_decode($products);
    }
}
