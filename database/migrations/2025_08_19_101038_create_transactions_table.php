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
       Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->string('idRequete')->unique();
    $table->string('refCommande');
    $table->string('numeroClient');
    $table->integer('montant');
    $table->string('description')->nullable();
    $table->string('statut')->default('EN_ATTENTE'); // EN_ATTENTE, SUCCES, ECHEC
    $table->string('message')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
