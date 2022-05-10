<?php

namespace App\Services\RajaOngkir\Cache;

use Illuminate\Support\Facades\Cache;
use App\Services\RajaOngkir\Cache\ImportDB;

class CacheUrl extends ImportDB
{
    private static $bucket;
    private static $table;
    private static $type;

    protected static function caching($results)
    {
        self::$bucket = $results;

        return new static();
    }

    private static function _import()
    {
        $cache_type = strtolower(config('rajaongkir.cache_type'));
        if ($cache_type == 'database') {
            self::import(self::$table, self::$bucket, self::$type);
        } elseif ($cache_type == null) {
            echo 'Please set cache type.';
        } else {
            echo 'Cache type is not supported.';
        }

        self::$bucket = null;
        self::$type = null;
        self::$table = null;
    }

    protected static function province()
    {
        self::$table = config('rajaongkir.province_table');
        self::$type = 'prov';
        self::_import();
    }

    protected static function city()
    {
        self::$table = config('rajaongkir.city_table');
        self::$type = 'city';
        self::_import();
    }    
}
