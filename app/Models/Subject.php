<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'SubjectName',
        'SubjectCode',
        'Description',
        'degree_id',
    ];

    public function degree()
    {
        return $this->belongsTo(DegreeModel::class, 'degree_id');
    }
}
