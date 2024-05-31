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
        Schema::table('processos_mov', function (Blueprint $table) {
            $table->text('descricao')->change(); // Altera a coluna de string para text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processos_mov', function (Blueprint $table) {
            $table->string('descricao', 255)->change(); // Reverte a alteração, de text para string
        });
    }
};
