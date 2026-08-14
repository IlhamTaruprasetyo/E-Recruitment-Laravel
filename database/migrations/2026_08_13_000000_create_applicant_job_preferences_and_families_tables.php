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
        Schema::create('applicant_job_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained('applicant_profile')->onDelete('cascade');
            $table->string('interested_field_1')->nullable();
            $table->string('interested_field_2')->nullable();
            $table->string('interested_field_3')->nullable();
            $table->string('notice_period')->nullable();
            $table->decimal('expected_salary', 15, 2)->nullable();
            $table->boolean('is_willing_to_relocate')->default(false);
            $table->string('job_search_status')->nullable();
            $table->string('notification_period')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained('applicant_profile')->onDelete('cascade');
            $table->string('father_name')->nullable();
            $table->integer('father_birth_year')->nullable();
            $table->string('father_last_education')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_company')->nullable();
            $table->string('mother_name')->nullable();
            $table->integer('mother_birth_year')->nullable();
            $table->string('mother_last_education')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_company')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_families');
        Schema::dropIfExists('applicant_job_preferences');
    }
};
