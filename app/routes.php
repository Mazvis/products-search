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

Route::get('/getcurrencies', function() {
    ProductsParser::getCurrencies();
});

Route::get('/testdb', array(
    'uses' => 'ProductsController@writeProductsToDatabase',
    'as' => 'execute.products'
));

Route::get('/save-varlelt-products_to_db', function(){
    $parser = new ProductsParser();
    $parser->writeToDatabase();
});
