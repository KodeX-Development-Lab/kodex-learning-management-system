<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug');
            $table->foreignUuid('user_id')->constrained('users');
            $table->json('category_ids')->nullable();
            $table->json('language_ids')->nullable();
            $table->string('what_will_learn')->nullable();
            $table->string('requirement')->nullable();
            $table->longText('description')->nullable();
            $table->string('for_whom')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('preview')->default(0);
            $table->timestamp('last_updated_at');
            $table->string('level');
            $table->boolean('is_published')->default(0);
            $table->json('useful_links')->nullable();
            $table->integer('total_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
