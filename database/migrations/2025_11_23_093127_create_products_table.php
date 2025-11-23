<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // UML: id_barang
            $table->id(); 
            
            // UML: nama_barang
            $table->string('name'); 
            
            // UML: harga_barang (Pakai Decimal agar akurat untuk uang)
            $table->decimal('price', 12, 2); 
            $table->integer('stock'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};