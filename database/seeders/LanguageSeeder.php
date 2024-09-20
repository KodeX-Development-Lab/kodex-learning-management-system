<?php

namespace Database\Seeders;

use App\Modules\Languages\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ["name" => "English", "code" => "en"],
            ["name" => "Burmese", "code" => "mm"],
        ];

        foreach ($languages as $language) {
            Language::create([
                'name' => $language['name'],
                'slug' => Str::slug($language['name']),
                'code' => $language['code'],
            ]);
        }
    }
}
