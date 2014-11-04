<?php

namespace Mazvis\ProductsParser\Services;

use Mazvis\ProductsParser\Models\Product;
use Mazvis\ProductsParser\Models\ProductModel;

class DatabaseHelper
{
    public static function getExistingCategories()
    {
        return Product::getExistingCategories();
    }

    public static function getProducts()
    {
        return ProductModel::get();
    }

    public static function getProductsByCategory($category)
    {
        return ProductModel::where('category', '=', $category)->get();
    }

    public static function getProductsByCountry($country)
    {
        return ProductModel::where('country', '=', $country)->get();
    }

    public static function getProductsByCostAsc()
    {
        return ProductModel::orderBy('convertedPrice', 'ASC')->get();
    }

    public static function getProductsByCostDesc()
    {
        return ProductModel::orderBy('convertedPrice', 'DESC')->get();
    }
}