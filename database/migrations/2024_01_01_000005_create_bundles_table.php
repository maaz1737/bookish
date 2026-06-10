<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->decimal('total_price', 10, 2)->default(0);   // sum of book prices
            $table->decimal('discount', 5, 2)->default(0);       // percentage e.g. 10.00
            $table->decimal('final_price', 10, 2)->default(0);   // computed
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // One master bundle per school+class
            $table->unique(['school_id', 'class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
