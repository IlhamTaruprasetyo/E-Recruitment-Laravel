<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('disc_profiles', function (Blueprint $table) {
            $table->text('suitable_jobs')->nullable()->after('general_description');
        });
    }

    public function down(): void
    {
        Schema::table('disc_profiles', function (Blueprint $table) {
            $table->dropColumn('suitable_jobs');
        });
    }
};
