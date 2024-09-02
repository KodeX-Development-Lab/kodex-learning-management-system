<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Course\Model\Course;
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

        $roles = ['Super Admin', 'Admin', 'Manager', 'Teacher', 'Finance', 'Office Staff', 'Student'];
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }

        User::create([
            'name' => 'Super Admin',
            'slug' => Str::slug('Super Admin'),
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234'),
        ]);

        $user = User::first();

        $user->assignRole('Super Admin');

        Course::create(['id' => (string) Str::uuid(),
            'title' => 'Introduction to Programming',
            'slug' => 'introduction-to-programming',
            'user_id' => $user->id, // Replace with actual user ID or logic
            'category_ids' => json_encode(['1', '2']),
            'language_ids' => json_encode(['3']),
            'what_will_learn' => 'Basics of programming and problem-solving techniques.',
            'requirement' => 'No prior knowledge required.',
            'description' => 'This course covers the fundamental concepts of programming with hands-on exercises.',
            'for_whom' => 'Beginners interested in learning programming.',
            'thumbnail' => 'path/to/thumbnail.jpg',
            'preview' => 1,
            'total_time' => 30,
            'level' => 'Beginner',
            'last_updated_at' => now(),
            'is_published' => 1,
            'useful_links' => json_encode(['https://example.com']),
            'created_at' => now(),
            'updated_at' => now()]);

    }
}
