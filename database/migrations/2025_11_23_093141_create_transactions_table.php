<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            // UML: id_transaksi
            $table->id(); 
            
            // UML: id_user (Relasi ke tabel users)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // UML: total_pemasukan
            $table->decimal('total_amount', 12, 2)->default(0); 
            
            // UML: status_pembayaran
            $table->string('payment_status')->default('paid'); // Default Lunas
            
            // UML: tgl (Diwakili oleh created_at)
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};