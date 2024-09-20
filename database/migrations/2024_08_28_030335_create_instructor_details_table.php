<?php

use App\Modules\Instructors\Enums\InstructorStatus;
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
        Schema::create('instructor_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('professional_field_id')->constrained()->onDelete('cascade');
            $table->integer('work_experience_year');
            $table->integer('teaching_experience_year');
            $table->enum('status', array_column(InstructorStatus::cases(), 'value'))->default('Pending');
            $table->integer('acted_by')->default(0);
            $table->dateTime('acted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_details');
    }
};
