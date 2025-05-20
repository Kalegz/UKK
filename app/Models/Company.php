<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'address', 'is_approved'];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function PKL_Assignment()
    {
        return $this->hasMany(PKL_Assignment::class);
    }
}