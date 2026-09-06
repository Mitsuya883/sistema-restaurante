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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tipo_comprobante')->default('ticket')->after('status');
            $table->string('nro_documento')->nullable()->after('tipo_comprobante');
            $table->string('razon_social')->nullable()->after('nro_documento');
            $table->string('direccion_fiscal')->nullable()->after('razon_social');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
