<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'province_id', 'ibge_code', 'status'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
