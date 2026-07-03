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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('email');
            $table->foreignId('shipping_zone_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('shipping_rate_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
            $table->string('shipping_method');
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipping_zone_id']);
            $table->dropForeign(['shipping_rate_id']);
            $table->dropColumn([
                'email',
                'shipping_zone_id',
                'shipping_rate_id',
                'shipping_method',
                'shipping_cost',
                'subtotal',
            ]);
        });
    }
};
