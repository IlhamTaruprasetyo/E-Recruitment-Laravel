<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rank')->default(0)->comment('Angka urutan tingkatan pendidikan');
            $table->timestamps();
        });

        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('job_degrees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('degree_id')->constrained('degrees')->cascadeOnDelete();
        });

        Schema::create('job_majors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('major_id')->constrained('majors')->cascadeOnDelete();
        });

        Schema::table('educations', function (Blueprint $table) {
            $table->foreignId('degree_id')->nullable()->after('profile_id')->constrained('degrees')->nullOnDelete();
            $table->foreignId('major_id')->nullable()->after('degree_id')->constrained('majors')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('educations', function (Blueprint $table) {
            $table->dropForeign(['degree_id']);
            $table->dropForeign(['major_id']);
            $table->dropColumn(['degree_id', 'major_id']);
        });

        Schema::dropIfExists('job_majors');
        Schema::dropIfExists('job_degrees');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('degrees');
    }
};
