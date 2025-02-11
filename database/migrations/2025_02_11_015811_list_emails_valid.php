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
        Schema::create('ListEmailsValid', function (Blueprint $table) {
            $table->id();  // Chave primária auto-incremento
            
        
            $table->string('email', 50);
           

           
            $table->timestamps();  // Colunas created_at e updated_at
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ListEmailsValid');
    }
};
