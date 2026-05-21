<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserAccount extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'password_changed'
    ];

    public function student()
    {
        return $this->hasOne(StudentModel::class, 'user_account_id');
    }

    public function teacher()
    {
        return $this->hasOne(TeacherModel::class, 'user_account_id');
    }
}
