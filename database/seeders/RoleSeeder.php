<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Instructors\Enums\InstructorStatus;
use App\Modules\Instructors\Models\InstructorDetail;
use App\Modules\ProfessionalField\Models\ProfessionalField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = ['Admin', 'Instructor', 'Student'];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }

        $user = User::create([
            'name'     => 'Super Admin',
            'slug'     => Str::slug('Super Admin'),
            'email'    => 'admin@example.com',
            'password' => Hash::make('admin1234'),
        ]);

        $professionalField = ProfessionalField::first();
        $instructor_detail = InstructorDetail::create([
            'user_id'                   => $user->id,
            'professional_field_id'     => $professionalField->id,
            'work_experience_years'     => 2,
            'teaching_experience_years' => 2,
            'status'                    => InstructorStatus::APPROVED->value,
        ]);

        $user->assignRole(['Admin', 'Instructor', 'Student']);
    }
}
