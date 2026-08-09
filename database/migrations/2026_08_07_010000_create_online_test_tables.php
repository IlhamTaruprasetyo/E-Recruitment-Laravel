<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. test_categories
        Schema::create('test_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. question_banks
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('test_categories')->cascadeOnDelete();
            $table->text('question');
            $table->string('question_type')->default('multiple_choice'); // e.g. multiple_choice, essay
            $table->string('image_path')->nullable();
            $table->integer('points')->default(1);
            $table->timestamps();
        });

        // 3. question_options
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('question_banks')->cascadeOnDelete();
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
        });

        // 4. tests
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('test_categories')->cascadeOnDelete();
            $table->string('title');
            $table->integer('duration_minutes');
            $table->decimal('passing_score', 5, 2)->default(0);
            $table->integer('total_questions')->default(0);
            $table->boolean('is_random')->default(false);
            $table->timestamps();
        });

        // 5. test_questions
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('question_banks')->cascadeOnDelete();
            $table->integer('order_number')->default(1);
        });

        // 6. test_attempts
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained('job_applications')->cascadeOnDelete();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->integer('duration')->nullable(); // in seconds/minutes
            $table->decimal('objective_score', 5, 2)->nullable();
            $table->decimal('essay_score', 5, 2)->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->string('status')->default('in_progress'); // e.g. in_progress, completed, passed, failed
        });

        // 7. test_answers
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('test_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('question_banks')->cascadeOnDelete();
            $table->foreignId('option_id')->nullable()->constrained('question_options')->nullOnDelete();
            $table->text('essay_answer')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('test_answers');
        Schema::dropIfExists('test_attempts');
        Schema::dropIfExists('test_questions');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('question_banks');
        Schema::dropIfExists('test_categories');
    }
};
