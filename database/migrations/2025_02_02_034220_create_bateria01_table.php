<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bateria01', function (Blueprint $table) {
            $table->id();  // Chave primária auto-incremento
            
            $table->string('POS', 3)->comment('Posição (pode conter "NC" para Não Classificado)');
            $table->integer('Kart');
            $table->unsignedBigInteger('user_id'); // Chave estrangeira para users
            $table->integer('MV');
            $table->time('TMV', 3)->comment('Formato: HH:MM:SS.sss');
            $table->time('IT', 3);
            $table->time('DL', 3);
            $table->time('DA', 3);
            $table->time('TUV', 3);
            $table->integer('TV');
            $table->decimal('VM', 10, 5)->comment('Velocidade em Km/h');

            $table->timestamps();  // Colunas created_at e updated_at
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Bateria03');
    }
};