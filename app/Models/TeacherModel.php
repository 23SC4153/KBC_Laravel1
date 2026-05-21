<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherModel extends Model
{
    protected $table = 'teachers';

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'contact',
        'specialization',
        'user_account_id'
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_account_id');
    }

    protected static function booted()
    {
        static::saved(function ($teacher) {
            try {
                if ($teacher->userAccount && $teacher->email) {
                    $teacher->userAccount->email = $teacher->email;
                    $teacher->userAccount->saveQuietly();
                }
            } catch (\Throwable $e) {
                // ignore sync errors
            }
        });

        static::deleting(function ($teacher) {
            try {
                if (! $teacher->userAccount) return;

                $user = $teacher->userAccount;
                $userId = $user->id;

                $hasOtherTeachers = static::where('user_account_id', $userId)->where('id', '!=', $teacher->id)->exists();
                $hasStudents = \App\Models\StudentModel::where('user_account_id', $userId)->exists();

                if (! $hasOtherTeachers && ! $hasStudents && $user->role !== 'admin') {
                    $user->delete();
                }
            } catch (\Throwable $e) {
                // ignore deletion errors
            }
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }
}
