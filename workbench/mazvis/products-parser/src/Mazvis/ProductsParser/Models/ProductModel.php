<?php

namespace Mazvis\ProductsParser\Models;

use Eloquent;

class ProductModel extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

    protected $fillable = [
        'description',
        'images',
        'deepLink',
        'country',
        'originalPrice',
        'originalCurrency',
        'convertedPrice',
        'convertedCurrency',
        'date'
    ];

}
