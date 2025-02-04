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
        Schema::create('ranking', function (Blueprint $table) {
            $table->id();  // Chave primária auto-incremento
            
            $table->integer('pontos');
            $table->string('name', 50);
           
            $table->unsignedBigInteger('user_id'); // Chave estrangeira para users
            $table->string('TMV', 50)->comment('Formato: HH:MM:SS.sss');
           
            $table->timestamps();  // Colunas created_at e updated_at
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking');
    }
};
