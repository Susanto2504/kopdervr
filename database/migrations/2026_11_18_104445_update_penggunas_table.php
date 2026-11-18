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
        Schema::table('penggunas', function (Blueprint $table) {
            $table->dropColumn(['nomor_telepon', 'status']);

            $table->string('peran')->default('Admin')->change();
        });
    }

    public function down(): void
    {
        Schema::table('penggunas', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable();
            $table->string('status')->default('aktif');

            $table->string('peran')->default('customer')->change();
        });
    }
};
