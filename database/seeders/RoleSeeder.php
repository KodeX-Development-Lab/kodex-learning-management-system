<?php

namespace Database\Seeders;

use App\Models\User;
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

        $user->assignRole(['Admin', 'Instructor', 'Student']);
    }
}
