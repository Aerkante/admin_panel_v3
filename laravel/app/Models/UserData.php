<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_id',
        'birthday',
        'telephone',
        'phone',
        'rg',
        'cpf',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
