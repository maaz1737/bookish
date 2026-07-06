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
        Schema::table('banners', function (Blueprint $table) {
            $table->string('top_tagline')->nullable()->after('title');
            $table->string('main_headline')->nullable()->after('top_tagline');
            $table->text('subheadline')->nullable()->after('main_headline'); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['top_tagline', 'main_headline', 'subheadline']);
        });
    }
};