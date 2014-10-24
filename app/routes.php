<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use Mazvis\ProductsParser\ProductsParser;

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/test', function(){
    echo ProductsParser::greeting();
});

Route::get('/curlvarlelt', function(){
    ProductsParser::curlVarleLtPage();
});

Route::get('/curlscytech', function(){
    return ProductsParser::curlVarleLtPage();
});

Route::get('/getcurrencies', function(){
    $string = ProductsParser::getCurrencies();

    $bear               = new Product;
    $bear->title         = $string;
    $bear->user_id        = 12;
    // save the bear to the database
    $bear->save();
});

Route::get('/testdb', array(
    'uses' => 'ProductsController@writeProductsToDatabase',
    'as' => 'execute.products'
));

Route::get('/testwb', function(){
    ProductsParser::writeToDatabase();
});
