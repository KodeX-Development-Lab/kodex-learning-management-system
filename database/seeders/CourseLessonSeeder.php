<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Categories\Models\Category;
use App\Modules\Course\Model\Course;
use App\Modules\Languages\Models\Language;
use App\Modules\Topics\Models\Topic;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user     = User::first();
        $category = Category::first();
        $language = Language::first();

        $course = Course::create([
            'title'              => 'Introduction to Programming',
            'slug'               => 'introduction-to-programming',
            'user_id'            => $user->id,
            'category_id'        => $category->id,
            'language_id'        => $language->id,
            'description'        => 'Introduction to Programming',
            'what_will_learn'    => 'Basics of programming and problem-solving techniques.',
            'requirements'       => 'No prior knowledge required.',
            'details'            => 'This course covers the fundamental concepts of programming with hands-on exercises.',
            'for_whom'           => 'Beginners interested in learning programming.',
            'thumbnail'          => 'courses/thumbnail.jpg',
            'preview_video_url'  => "https://www.youtube.com/watch?v=PuOVqP_cjkE",
            'level'              => 'Beginner',
            'is_published'       => 1,
            'useful_links'       => ['https://example.com'],
            'total_time_minutes' => 310,
            'last_updated_at'    => Carbon::now(),
            'created_at'         => Carbon::now(),
            'updated_at'         => Carbon::now(),
        ]);

        $topics = Topic::take(2)->get();

        $course->topics()->sync($topics);
    }
}
