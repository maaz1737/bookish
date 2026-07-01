<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();        // public reference e.g. BK-2024-0001
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // null = guest

            // Guest shipping fields (Auth 5.1)
            $table->string('customer_name');
            $table->string('mobile', 50);
            $table->text('address');

            $table->decimal('total_amount', 10, 2);

            // Payment lifecycle (Section 8) + Order workflow (Section 9)
            $table->enum('payment_status', ['pending', 'paid'])
                ->default('pending');
            $table->enum('order_status', ['pending', 'shipped', 'delivered', 'returned'])
                ->default('pending');

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
