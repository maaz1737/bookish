<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bundles', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign('bundles_school_id_foreign');
            $table->dropForeign('bundles_class_id_foreign');
            
            // Drop unique constraint
            $table->dropUnique('bundles_school_id_class_id_unique');
            
            // Make school_id and class_id nullable
            $table->unsignedBigInteger('school_id')->nullable()->change();
            $table->unsignedBigInteger('class_id')->nullable()->change();
            
            // Re-add foreign keys and individual indexes
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('school_classes')->cascadeOnDelete();
            
            // Add name column
            $table->string('name')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn('name');
            
            $table->dropForeign(['school_id']);
            $table->dropForeign(['class_id']);
            
            // Re-add unique constraint (which requires values to be non-nullable)
            $table->unsignedBigInteger('school_id')->nullable(false)->change();
            $table->unsignedBigInteger('class_id')->nullable(false)->change();
            
            $table->unique(['school_id', 'class_id']);
            
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('school_classes')->cascadeOnDelete();
        });
    }
};
