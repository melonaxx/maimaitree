<?php
namespace App\Extend;
use Illuminate\Support\Facades\Redis;

const NON_EXPIRE = 0;
class CacheDriver
{
    public static function GET( $key )
    {
        return Redis::command('GET', $key );
    }

    public static function SET( $key, $value, $expire = self::NON_EXPIRE )
    {
        return Redis::command('SET', $key, $value,  $expire );
    }

    public static function INCREMENT( $key, $value = 1 )
    {
        return Redis::command('INCREMENT', $key, $value );
    }

    public static function DECREMENT( $key, $value = 1 )
    {
        return Redis::command('DECREMENT', $key, $value );
    }

    public static function UPDATE( $key, $value )
    {
        $value = (int) $value;
        if ( $value > 0 )
        {
            return Redis::command('INCREMENT', $key, $value );
        }
        return Redis::command('DECREMENT', $key, $value );
    }

    public static function HSET( $map, $key, $value)
    {
        return Redis::command('HSET', [$map, $key, $value] );
    }

    public static function HGET( $map, $key)
    {
        return Redis::command('HGET', [$map, $key] );
    }

    public static function HGETALL( $map)
    {
        return Redis::command('HGETALL', [$map] );
    }

    public static function HEXISTS( $map, $key)
    {
        return Redis::command('HEXISTS', [$map, $key] );
    }
}
?>
