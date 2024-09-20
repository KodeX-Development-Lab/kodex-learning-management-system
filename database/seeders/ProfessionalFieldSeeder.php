<?php

namespace Database\Seeders;

use App\Modules\ProfessionalField\Models\ProfessionalField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfessionalFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professional_fields = ['Web Developer', 'Accountant', 'DevOps Engineer'];

        foreach ($professional_fields as $professional_field) {
            ProfessionalField::create([
                'name' => $professional_field,
                'slug' => Str::slug($professional_field),
            ]);
        }
    }
}
