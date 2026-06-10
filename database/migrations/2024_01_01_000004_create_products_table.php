<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('school_id')->nullable()->constrained('schools')->nullOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->nullOnDelete();

            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('low_stock_threshold')->default(5);

            // Hidden from all public endpoints (Central Rule: Information Masking)
            $table->string('publisher')->nullable();

            // Uniform-specific variant attributes (nullable for non-uniforms)
            $table->string('size')->nullable();   // S, M, L, XL or numeric
            $table->enum('gender', ['boys', 'girls', 'unisex'])->nullable();

            $table->text('description')->nullable();
            $table->json('images')->nullable();    // array of stored image paths
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['school_id', 'class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
