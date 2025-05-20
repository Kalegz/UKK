<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRequest extends Model
{
    protected $fillable = ['name', 'address', 'student_id', 'is_approved'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
