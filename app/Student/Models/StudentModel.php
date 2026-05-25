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
    protected $table = 'student_models';

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
