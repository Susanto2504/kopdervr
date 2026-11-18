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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('xendit_qr_id')->nullable();
            $table->string('status_pembayaran')->default('PENDING');
            $table->string('xendit_payment_id')->nullable();
            $table->timestamp('dibayar_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn([
                'xendit_qr_id',
                'status_pembayaran',
                'xendit_payment_id',
                'dibayar_pada',
            ]);
        });
    }
};
