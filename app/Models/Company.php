<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'business fields', 'address', 'contact', 'email', 'is_approved'];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function PKL_Assignment()
    {
        return $this->hasMany(PKL_Assignment::class);
    }
}