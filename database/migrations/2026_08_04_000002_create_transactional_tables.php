<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('profile_id')->constrained('applicant_profile')->cascadeOnDelete();
            $table->string('status');
            $table->timestamp('applied_at');
            $table->text('notes')->nullable();
        });

        Schema::create('application_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_applications_id')->constrained('job_applications')->cascadeOnDelete();
            $table->string('status');
            $table->text('notes')->nullable();
            $table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('changed_at');
        });

        Schema::create('interview_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_applications_id')->constrained('job_applications')->cascadeOnDelete();
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('interview_date');
            $table->string('location');
            $table->string('meeting_link')->nullable();
            $table->string('status');
        });
    }

    public function down(): void {
        Schema::dropIfExists('interview_schedule');
        Schema::dropIfExists('application_status_history');
        Schema::dropIfExists('job_applications');
    }
};
