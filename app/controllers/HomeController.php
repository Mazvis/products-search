<?php

use Mazvis\ProductsParser\ProductsParser;

class HomeController extends BaseController
{
    public function showHome()
    {
        $this->layout->content = View::make('homeOld');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $products = ProductsParser::getProducts();
        $products = json_decode($products);
        $content->products = $this->getImages($products);

        $content->textLikeTitle = 'Visi produktai:';
    }

    public function showByCategory($categoryName = null)
    {
        $this->layout->content = View::make('homeOld');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $content->products = [];
        $content->textLikeTitle = 'no found';
        if ($categoryName) {
            $products = ProductsParser::getProductsByCategory($categoryName);
            $products = json_decode($products);
            $content->products = $this->getImages($products);
            $content->textLikeTitle = 'Kategorijos "' . $categoryName . '" prekės:';
        }
    }

    public function showByCountry($countryName = null)
    {
        $this->layout->content = View::make('homeOld');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $content->products = [];
        $content->textLikeTitle = 'no found';
        if ($countryName) {
            $products = ProductsParser::getProductsByCountry($countryName);
            $products = json_decode($products);
            $content->products = $this->getImages($products);
            $content->textLikeTitle = 'Šalies "' . $countryName . '" prekės:';
        }
    }

    public function search()
    {
        $content = $this->layout->content;

        $keyword = Input::get('s');

        $content->products = [];
        $content->textLikeTitle = "Paieška pagal: '" . $keyword . "': ";
        $products = ProductsParser::doSearch($keyword);
        $products = json_decode($products);
        $content->products = $this->getImages($products);
    }

    private function getImages($products)
    {
        $productsNew = $products;
        foreach ($products as $key => $product) {
            $productsNew[$key]->images = json_decode($product->images);
        }
        return $productsNew;
    }
}
