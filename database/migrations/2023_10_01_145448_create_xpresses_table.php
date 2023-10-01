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
        Schema::create('xpresses', function (Blueprint $table) {
            $table->id();
            $table->integer('Montant');
            $table->string('Nom_client');
            $table->integer('commission');

            $table->unsignedBigInteger('solde_Xpress_id');
            $table->foreign('solde_Xpress_id')->references('id')->on('solde_xpresses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xpresses');
    }
};
