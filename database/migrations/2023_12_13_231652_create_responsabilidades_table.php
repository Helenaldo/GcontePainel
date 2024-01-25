<?php

use App\Models\Cliente;
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
        Schema::create('responsabilidades', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cliente::class);
            $table->unsignedBigInteger('contabil')->nullable();
            $table->unsignedBigInteger('pessoal')->nullable();
            $table->unsignedBigInteger('fiscal')->nullable();
            $table->unsignedBigInteger('paralegal')->nullable();
            $table->date('data');
            $table->timestamps();

            // Adiciona a relação de chave estrangeira
            $table->foreign('contabil')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pessoal')->references('id')->on('users')->onDelete('set null');
            $table->foreign('fiscal')->references('id')->on('users')->onDelete('set null');
            $table->foreign('paralegal')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsabilidades');
    }
};
