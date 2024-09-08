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
        Schema::create('instructors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('professional_field_id')->constrained()->onDelete('cascade');
            $table->integer('work_experience_year');
            $table->integer('teaching_experience_year');
            $table->enum('approve_status', ['Pending', 'Cancelled', 'Rejected', 'Freeze', 'Approved'])->default('Pending');
            $table->integer('approved_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
