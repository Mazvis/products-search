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
    private static $tableName = 'products';

    /** @var array  */
    protected $fillable = [
        'provider',
        'providerQuantity',
        'name',
        'category',
        'description',
        'images',
        'deepLink',
        'country',
        'originalPrice',
        'originalCurrency',
        'convertedPrice',
        'convertedCurrency',
        'timestamp'
    ];

    /**
     * @return string
     */
    public static function getTableName()
    {
        return self::$tableName;
    }
}
