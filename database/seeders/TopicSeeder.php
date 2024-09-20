<?php

namespace Database\Seeders;

use App\Modules\Topics\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = ['HTML', 'CSS', 'React', 'C#', 'AWS'];

        foreach ($topics as $topic) {
            Topic::create([
                'name' => $topic,
                'slug' => Str::slug($topic),
            ]);
        }
    }
}
