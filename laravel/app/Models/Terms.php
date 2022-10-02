<?php

namespace App\Models;

use App\Models\Traits\CacheTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use HasFactory, CacheTrait;

    protected $fillable = [
        'status',
        'terms',
        "company_id"
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
