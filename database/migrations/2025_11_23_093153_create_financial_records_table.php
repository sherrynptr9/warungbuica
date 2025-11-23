<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            
            // UML: tgl
            $table->date('date'); 
            
            // UML: nominal
            $table->decimal('amount', 12, 2); 
            
            // Tambahan Penting: Jenis (Pemasukan/Pengeluaran)
            $table->enum('type', ['income', 'expense']); 
            
            // UML: keterangan
            $table->string('description'); 
            
            // UML: id_user (Siapa yang mencatat)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};