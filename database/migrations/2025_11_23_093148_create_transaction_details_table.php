<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel transactions
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            
            // UML: id_barang (Relasi ke tabel products)
            $table->foreignId('product_id')->constrained('products'); 
            
            // UML: item_terjual
            $table->integer('quantity'); 
            
            // Harga saat transaksi (disimpan agar jika harga barang naik, data lama tidak berubah)
            $table->decimal('price', 12, 2); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};