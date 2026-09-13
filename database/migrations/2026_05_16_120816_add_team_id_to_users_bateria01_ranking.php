<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('must_change_password')
                ->constrained('teams')->nullOnDelete();
        });

        Schema::table('bateria01', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('corrida')
                ->constrained('teams')->nullOnDelete();
        });

        Schema::table('ranking', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('user_id')
                ->constrained('teams')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });

        Schema::table('bateria01', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });

        Schema::table('ranking', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
    }
};
