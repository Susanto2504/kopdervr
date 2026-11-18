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
        Schema::create('pesanans', function (Blueprint $table) {
             $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nomor_invoice')->unique();

            $table->string('metode_pembayaran')->nullable();
            $table->string('metode_pengiriman')->nullable();
            $table->string('status_pesanan')->default('pending');

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('biaya_pengiriman', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('total_pembayaran', 15, 2)->default(0);

            $table->text('catatan_pelanggan')->nullable();

            $table->string('nama_penerima');
            $table->string('nomor_telepon_penerima');
            $table->text('alamat_pengiriman');

            $table->timestamp('tanggal_pesanan')->nullable();
            $table->timestamp('dikonfirmasi_pada')->nullable();
            $table->timestamp('diproses_pada')->nullable();
            $table->timestamp('dikirim_pada')->nullable();
            $table->timestamp('diterima_pada')->nullable();
            $table->timestamp('dibatalkan_pada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
