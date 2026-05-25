<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\DegreeModel;
use App\Models\Subject;
use App\Models\TeacherModel;
use App\Models\StudentModel;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 10 degrees
        $degrees = [];
        for ($i = 1; $i <= 10; $i++) {
            $degrees[] = DegreeModel::create([
                'DegreeName' => 'Degree ' . $i,
                'DegreeCode' => 'DGR' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'Description' => $faker->sentence(),
            ]);
        }

        // Create 20 subjects (two subjects per degree)
        for ($i = 1; $i <= 20; $i++) {
            Subject::create([
                'SubjectName' => 'Subject ' . $i,
                'SubjectCode' => 'SUB' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'Description' => $faker->sentence(),
                'degree_id' => $degrees[($i - 1) % count($degrees)]->id,
            ]);
        }

        // Create 10 teachers
        for ($i = 1; $i <= 10; $i++) {
            TeacherModel::create([
                'fname' => $faker->firstName(),
                'mname' => $faker->optional()->firstName(),
                'lname' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'contact' => $faker->phoneNumber(),
                'specialization' => $faker->jobTitle(),
                'user_account_id' => null,
            ]);
        }

        $subjectsByDegree = Subject::all()->groupBy('degree_id');

        // Create 10 students and enroll each one in a few subjects from their degree
        for ($i = 1; $i <= 10; $i++) {
            $student = StudentModel::create([
                'fname' => $faker->firstName(),
                'mname' => $faker->optional()->firstName(),
                'lname' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'contact' => $faker->phoneNumber(),
                'degree_id' => $degrees[($i - 1) % count($degrees)]->id,
                'user_account_id' => null,
            ]);

            $degreeSubjects = $subjectsByDegree->get($student->degree_id, collect());

            if ($degreeSubjects->isNotEmpty()) {
                $student->subjects()->attach(
                    $degreeSubjects->take(min(2, $degreeSubjects->count()))->pluck('id')->all()
                );
            }
        }
    }
}
