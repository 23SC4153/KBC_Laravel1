<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['CourseCode', 'CourseName', 'description', 'teacher_id'];

    public function students()
    {
        return $this->belongsToMany(StudentModel::class, 'course_student_model', 'course_id', 'student_id')
            ->using(CourseStudent::class)
            ->withTimestamps();
    }

    public function teacher()
    {
        return $this->belongsTo(TeacherModel::class, 'teacher_id');
    }
}
