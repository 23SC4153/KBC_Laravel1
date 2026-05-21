<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DegreeModel extends Model
{
    //
     protected $table = 'degree_models';

    protected $fillable = [
        'DegreeName',
        'DegreeCode',
        'Description',
    ];

    public function students()
    {
        return $this->hasMany(StudentModel::class, 'degree_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'degree_id');
    }
}
