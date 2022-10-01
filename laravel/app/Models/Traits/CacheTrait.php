<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheTrait
{

    public static function boot()
    {
        parent::boot();
        static::saved(function ($obj) {
            Cache::tags($obj->getTable())->flush();
        });

        static::created(function ($obj) {
            Cache::tags($obj->getTable())->flush();
        });

        static::updated(function ($obj) {
            Cache::tags($obj->getTable())->flush();
        });

        static::deleted(function ($obj) {
            Cache::tags($obj->getTable())->flush();
        });
    }

    public static function cacheTag()
    {
        /** @var \Illuminate\Database\Eloquent\Model */
        $model = app(self::class);

        return $model->getTable();
    }
}
