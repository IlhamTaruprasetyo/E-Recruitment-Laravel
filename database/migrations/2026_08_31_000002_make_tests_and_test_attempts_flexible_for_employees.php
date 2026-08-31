<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Make tests table flexible
        Schema::table('tests', function (Blueprint $table) {
            $table->foreignId('job_id')->nullable()->change();
            $table->string('test_type')->default('recruitment')->after('job_id'); // 'recruitment' or 'employee'
            $table->foreignId('department_id')->nullable()->after('test_type')->constrained('departments')->nullOnDelete();
        });

        // 2. Make test_attempts table flexible
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->foreignId('job_application_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->after('job_application_id')->constrained('users')->cascadeOnDelete();
            $table->string('attempt_type')->default('applicant')->after('user_id'); // 'applicant' or 'employee'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'attempt_type']);
        });

        Schema::table('tests', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['test_type', 'department_id']);
        });
    }
};
