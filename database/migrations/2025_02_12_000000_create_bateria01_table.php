<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bateria01', function (Blueprint $table) {
            $table->id();
            $table->integer('POS')->nullable();
            $table->integer('Kart')->default(999);
            $table->string('name', 50);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('MV')->default(0);
            $table->string('TMV')->nullable();
            $table->string('TT')->nullable();
            $table->string('DL')->nullable();
            $table->string('DA')->nullable();
            $table->string('TUV')->nullable();
            $table->integer('TV')->default(0);
            $table->string('VM')->nullable();
            $table->integer('corrida')->default(1);
            $table->date('date_corrida')->nullable();
            $table->dateTime('update_ranking')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bateria01');
    }
};
