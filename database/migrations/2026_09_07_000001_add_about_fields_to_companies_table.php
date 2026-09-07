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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('tagline')->nullable()->after('name');
            $table->text('about')->nullable()->after('website');
            $table->text('vision')->nullable()->after('about');
            $table->json('missions')->nullable()->after('vision');
            $table->json('core_values')->nullable()->after('missions');
            $table->string('postal_code', 20)->nullable()->after('province');
            $table->string('phone', 50)->nullable()->after('postal_code');
            $table->string('email')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'tagline',
                'about',
                'vision',
                'missions',
                'core_values',
                'postal_code',
                'phone',
                'email',
            ]);
        });
    }
};
