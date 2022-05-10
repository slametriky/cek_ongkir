<?php

namespace App\Services\RajaOngkir;

use Exception;
use App\Services\RajaOngkir\Api;
use App\Services\RajaOngkir\Cache\ROCache;

class Ongkir extends Api
{
    private static $arr;
    private static $return;
    private static $province;
    private static $city;
    private static $cacheType;

    public static function find($arr)
    {
        if (is_array($arr)) {
            self::$arr = $arr;

            return new static();
        } else {
            throw new Exception('Parameter must be an array.');

            return false;
        }
    }

    public static function get()
    {
        self::$arr = null; //Clear parameter
        if (empty(self::$return)) {
            throw new Exception('Data is not defined.');

            return false;
        }
        $ret = self::$return;
        self::$return = null;
        
        return $ret;
    }

    public static function cachingProvince()
    {
        self::cacheProvince();
    }

    public static function cachingCity()
    {
        self::cacheCity();
    }    

    public static function province()
    {
        $ret = self::provinceData();
        self::$return = $ret;

        return new static();
    }

    public static function city()
    {
        $ret = self::cityData();
        self::$return = $ret;

        return new static();
    }

    private static function setupConfig()
    {
        self::$cacheType = strtolower(config('rajaongkir.cache_type'));
        self::$province = config('rajaongkir.province_table');
        self::$city = config('rajaongkir.city_table');
    }

    private static function provinceData()
    {
        if (function_exists('config') && function_exists('app')) {
            self::setupConfig();
            $cache_type = self::$cacheType;
            if ($cache_type == 'database') {
                if (ROCache::checkProv()) {
                    if (count(ROCache::getProv(self::$arr)) > 0) {
                        $ret = ROCache::getProv(self::$arr);
                    } else {
                        $ret = self::get_province(self::$arr);
                    }
                }
            } else {
                $ret = self::get_province(self::$arr);
            }
        } else {
            $ret = self::get_province(self::$arr);
        }

        return $ret;
    }

    private static function cityData()
    {
        if (function_exists('config') && function_exists('app')) {
            self::setupConfig();
            $cache_type = self::$cacheType;
            if ($cache_type == 'database') {
                if (ROCache::checkCity()) {
                    $ret = ROCache::getCity(self::$arr);                   
                }            
            } else {
                $ret = self::get_city(self::$arr);
            }
        } else {
            $ret = self::get_city(self::$arr);
        }

        return $ret;
    }    
}
