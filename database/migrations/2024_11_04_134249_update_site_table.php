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
        Schema::table('site', function (Blueprint $table) {
            $table->text('titre_site')->nullable();
            $table->text('description_site')->nullable();
            $table->text('keywords_site')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site', function (Blueprint $table) {
            $table->dropColumn('titre_site');
            $table->dropColumn('description_site');
            $table->dropColumn('keywords_site');
        });
    }
};
