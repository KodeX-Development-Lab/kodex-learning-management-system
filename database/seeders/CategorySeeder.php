<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Categories\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Web Development', 'Cloud', 'Networking'];

        $user = User::first();
        foreach ($categories as $category) {
            Category::create([
                'name'       => $category,
                'slug'       => Str::slug($category),
                'created_by' => $user->id ?? null,
            ]);
        }
    }
}
