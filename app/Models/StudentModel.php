<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DegreeModel;
use App\Models\UserAccount;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Subject;

class StudentModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_modelss';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'contact',
        'degree_id',
        'user_account_id'
    ];

    /**
     * Get the user account that owns the student.
     */
    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_account_id');
    }

    protected static function booted()
    {
        // Keep user email in sync when a student is saved
        static::saved(function ($student) {
            try {
                if ($student->userAccount && $student->email) {
                    $student->userAccount->email = $student->email;
                    $student->userAccount->saveQuietly();
                }
            } catch (\Throwable $e) {
                // ignore sync errors
            }
        });

        // Safe-delete: remove linked user only if no other student/teacher references it and not admin
        static::deleting(function ($student) {
            try {
                if (! $student->userAccount) return;

                $user = $student->userAccount;
                $userId = $user->id;

                $hasOtherStudents = static::where('user_account_id', $userId)->where('id', '!=', $student->id)->exists();
                $hasTeachers = \App\Models\TeacherModel::where('user_account_id', $userId)->exists();

                if (! $hasOtherStudents && ! $hasTeachers && $user->role !== 'admin') {
                    $user->delete();
                }
            } catch (\Throwable $e) {
                // ignore deletion errors
            }
        });
    }

    /**
     * Get the degree that the student belongs to.
     */
    public function degree()
    {
        return $this->belongsTo(DegreeModel::class, 'degree_id');
    }

    /**
     * The courses that belong to the student.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student_model', 'student_id', 'course_id')
            ->using(CourseStudent::class)
            ->withTimestamps();
    }

    /**
     * The subjects that belong to the student.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_student_model', 'student_id', 'subject_id')
            ->withTimestamps();
    }

    /**
     * Scope to get students by role (filters through UserAccount).
     */
    public function scopeByRole($query, $role)
    {
        return $query->whereHas('userAccount', function ($q) use ($role) {
            $q->where('role', $role);
        });
    }
}
