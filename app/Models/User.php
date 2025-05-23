<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function isTeacher()
    {
        return $this->hasRole('teacher');
    }

    public function isAnonymous()
    {
        return $this->hasRole('anonymous');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    public static function canEdit(User $user): bool
    {
        return auth()->user()->hasRole('admin');
    }

        public function syncRolesOnUpdate(array $roles)
    {
        $this->syncRoles($roles);
    }
}