<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseStudent extends Pivot
{
    protected $table = 'course_student_model';

    protected $fillable = [
        'course_id',
        'student_id',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }
}