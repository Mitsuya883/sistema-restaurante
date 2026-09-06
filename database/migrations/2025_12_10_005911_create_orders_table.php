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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('table_id')->nullable()->constrained()->onDelete('set null'); // Nulo si es Delivery
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // Nulo si es cliente anónimo en mesa

            $table->enum('order_type', ['dine_in', 'delivery', 'pickup'])->default('dine_in');
            $table->enum('status', ['pending', 'cooking', 'ready', 'delivered', 'paid', 'cancelled'])->default('pending');

            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
