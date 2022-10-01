<?php

namespace App\Models;

use App\Models\Traits\CacheTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CacheTrait;

    protected $fillable = [
        'trade_name',
        'cpf_cnpj',
        'category_id',
        'user_id',
        'phone',
        'operating_hours',
        'instagram',
        'status',
        'image_id',
        'logo',
    ];

    protected $appends = ['logo_url'];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) return null;
        $logo = url($this->logo);
        return $logo;
    }
}
