<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. disc_norms
        Schema::create('disc_norms', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('line_type');
            $table->char('attribute', 10);
            $table->integer('raw_score');
            $table->float('converted_score');
            $table->timestamps();
        });

        // 2. disc_profiles
        Schema::create('disc_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('pattern_code');
            $table->string('title');
            $table->text('general_description')->nullable();
            $table->timestamps();
        });

        // 3. disc_traits
        Schema::create('disc_traits', function (Blueprint $table) {
            $table->id();
            $table->char('dimension_code', 10);
            $table->json('potret_diri')->nullable();
            $table->json('kelebihan')->nullable();
            $table->json('kekurangan')->nullable();
            $table->text('deskripsi_tipe')->nullable();
            $table->json('kecenderungan')->nullable();
            $table->json('lingkungan_cocok')->nullable();
            $table->timestamps();
        });

        // 4. disc_test_results
        Schema::create('disc_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_attempt_id')->constrained('test_attempts')->cascadeOnDelete();
            $table->foreignId('disc_profiles_id')->nullable()->constrained('disc_profiles')->nullOnDelete();
            $table->json('line_1_scores')->nullable();
            $table->json('line_2_scores')->nullable();
            $table->json('line_3_scores')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('disc_test_results');
        Schema::dropIfExists('disc_traits');
        Schema::dropIfExists('disc_profiles');
        Schema::dropIfExists('disc_norms');
    }
};
