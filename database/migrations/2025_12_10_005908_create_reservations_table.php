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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('table_id')->nullable()->constrained()->onDelete('set null'); 
            $table->dateTime('reservation_date');
            $table->integer('guest_count');
            $table->enum('status', ['pendiente', 'confirmada', 'cancelada', 'completada', 'vencida', 'no_asistio'])->default('pendiente');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
