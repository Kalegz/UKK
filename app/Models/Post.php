<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Pastikan Anda mengimpor model User

class Post extends Model
{
    use HasFactory;

    // Jika menggunakan mass assignment, pastikan $fillable atau $guarded didefinisikan
    protected $fillable = [
        'title',
        'content',
        'image',
        'stock',
        'user_id',
    ];

    /**
     * Relationship: Setiap Post dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
