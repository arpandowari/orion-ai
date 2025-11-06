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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->decimal('cgpa', 3, 2)->nullable();
            $table->text('education_details')->nullable();
            $table->json('internship_experience')->nullable();
            $table->text('extracurricular_activities')->nullable();
            $table->text('goal')->nullable();
            $table->string('suitable_role')->nullable();
            $table->decimal('expected_ctc', 10, 2)->nullable();
            $table->string('resume_path');
            $table->string('marksheet_path');
            $table->enum('status', ['pending', 'contacted', 'verified'])->default('pending');
            $table->boolean('course_unlocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
