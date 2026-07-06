<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            'PAFWA Education System',
            'PAF Montessori School',
            'Fazaia School System',
        ];

        $classes = ['Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5'];

        foreach ($schools as $name) {
            $school = School::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true]
            );

            foreach ($classes as $i => $className) {
                SchoolClass::firstOrCreate(
                    ['school_id' => $school->id, 'slug' => Str::slug($className)],
                    ['name' => $className, 'sort_order' => $i + 1, 'is_active' => true]
                );
            }
        }
    }
}
