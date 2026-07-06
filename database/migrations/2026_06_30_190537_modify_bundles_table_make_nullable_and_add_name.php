<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->dropForeign('bundles_school_id_foreign');
            });
        } catch (\Throwable $e) {
            // Already dropped or doesn't exist
        }

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->dropForeign('bundles_class_id_foreign');
            });
        } catch (\Throwable $e) {
            // Already dropped or doesn't exist
        }

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->dropUnique('bundles_school_id_class_id_unique');
            });
        } catch (\Throwable $e) {
            // Already dropped or doesn't exist
        }

        // Make columns nullable
        Schema::table('bundles', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable()->change();
            $table->unsignedBigInteger('class_id')->nullable()->change();
        });

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
            // Already exists or couldn't add
        }

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->foreign('class_id')->references('id')->on('school_classes')->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
            // Already exists or couldn't add
        }

        if (!Schema::hasColumn('bundles', 'name')) {
            Schema::table('bundles', function (Blueprint $table) {
                $table->string('name')->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bundles', 'name')) {
            Schema::table('bundles', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->dropForeign('bundles_school_id_foreign');
            });
        } catch (\Throwable $e) {}

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->dropForeign('bundles_class_id_foreign');
            });
        } catch (\Throwable $e) {}

        Schema::table('bundles', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable(false)->change();
            $table->unsignedBigInteger('class_id')->nullable(false)->change();
        });

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->unique(['school_id', 'class_id']);
            });
        } catch (\Throwable $e) {}

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            });
        } catch (\Throwable $e) {}

        try {
            Schema::table('bundles', function (Blueprint $table) {
                $table->foreign('class_id')->references('id')->on('school_classes')->cascadeOnDelete();
            });
        } catch (\Throwable $e) {}
    }
};
