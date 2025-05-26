<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'nis', 'gender', 'class', 'major', 'address', 'contact', 'email'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pklAssignment()
    {
        return $this->hasOne(PKL_Assignment::class);
    }

    public function companyRequests()
    {
        return $this->hasMany(CompanyRequest::class);
    }
}