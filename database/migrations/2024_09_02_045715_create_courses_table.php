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
            $table->foreignUuid('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('language_id')->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('what_will_learn')->nullable();
            $table->text('requirements')->nullable();
            $table->longText('details')->nullable();
            $table->text('for_whom')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('preview_video_url')->default(0);
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced']);
            $table->boolean('is_published')->default(0);
            $table->json('useful_links')->nullable();
            $table->integer('total_time_minutes')->default(0);
            $table->dateTime('last_updated_at')->nullable();
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
