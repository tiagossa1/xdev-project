<?php

use App\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    private $months = [5, 10];
    private $years = [20, 21];

    private function populateCourse($courses, $schoolId)
    {
        foreach ($courses as $course) {
            foreach ($this->months as $month) {
                foreach ($this->years as $year) {
                    SchoolClass::create([
                        'name' => $course . ' ' . sprintf('%02d', $month) . '.' . $year,
                        'school_id' => $schoolId
                    ]);
                }
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $i == 1
        $matosinhosCourses = ["GRSI", "TPSI", "MAPCP", "ARCI", "CISEG", "TM"];

        // $i == 2
        $palmelaCourses = ["GRSI", "TPSI", "MAPCP", "ARCI", "CISEG", "TM"];

        // $i == 3
        $cascaisCourses = ["TPSI", "MAPCP"];

        // $i == 4
        $madeiraCourses = ["TM"];

        // $i == 5
        $carregadoCourses = ["TM"];

        $this->populateCourse($matosinhosCourses, 1);
        $this->populateCourse($palmelaCourses, 2);
        $this->populateCourse($cascaisCourses, 3);
        $this->populateCourse($madeiraCourses, 4);
        $this->populateCourse($carregadoCourses, 5);
    }
}
