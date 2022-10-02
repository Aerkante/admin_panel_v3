<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'city_id',
        'addressable_id',
        'addressable_type',
        'zip',
        'street',
        'number',
        'neighborhood',
        'default_address',
        'status',
        'complement',
    ];

    protected $appends = ['province_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function getProvinceIdAttribute()
    {
        $city = $this->city;

        return $city->province_id ?? null;
    }
}
