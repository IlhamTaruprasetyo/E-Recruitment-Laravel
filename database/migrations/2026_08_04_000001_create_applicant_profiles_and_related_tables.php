<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('applicant_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nik')->nullable();
            $table->string('full_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('photo')->nullable();
            $table->string('npwp')->nullable();
            $table->text('about_me')->nullable();
            $table->string('generated_cv_url')->nullable();
            $table->timestamps();
        });

        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('name');
            $table->string('position');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('start_month');
            $table->year('start_year');
            $table->string('end_month')->nullable();
            $table->year('end_year')->nullable();
        });

        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('school_name');
            $table->string('degree');
            $table->string('major');
            $table->string('study_program')->nullable();
            $table->year('start_year');
            $table->year('end_year')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('company_name');
            $table->string('position');
            $table->string('employment_type');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('currently_working')->default(false);
            $table->text('description')->nullable();
        });

        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('name');
            $table->string('scale');
            $table->string('month');
            $table->year('year');
            $table->text('description')->nullable();
            $table->string('certificate_path')->nullable();
        });

        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('name');
            $table->string('certificate_path')->nullable();
        });

        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('name');
            $table->string('certificate_path')->nullable();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('name');
            $table->string('certificate_path')->nullable();
        });

        Schema::create('social_medias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('platform_name');
            $table->string('url');
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('name');
            $table->string('certificate_path')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('languages');
        Schema::dropIfExists('social_medias');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('trainings');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('work_experiences');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('applicant_profile');
    }
};
