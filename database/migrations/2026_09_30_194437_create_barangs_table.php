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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('dibuat_oleh')
                ->constrained('penggunas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nama');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->text('deskripsi')->nullable();
            $table->string('satuan');

            $table->decimal('harga_modal', 15, 2);
            $table->decimal('harga_jual', 15, 2);

            $table->integer('stok')->default(0);
            $table->integer('batas_stok_minimum')->default(0);

            $table->string('foto')->nullable();
            $table->string('status')->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
