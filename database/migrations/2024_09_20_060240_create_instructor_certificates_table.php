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
        Schema::create('instructor_certificates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('instructor_detail_id')->constrained('instructor_details')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_certificates');
    }
};
