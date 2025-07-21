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
        Schema::create('transaksi_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referensi_id')->constrained('referensis');
            $table->integer('harga_beli');
            $table->integer('volume');
            $table->integer('total');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuks');
    }
};
