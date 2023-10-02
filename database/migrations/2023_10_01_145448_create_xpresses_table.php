<?php

use App\Enums\TypesClass;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('Téléphone');
            $table->enum('Type',[
                TypesClass::Retrait()->value,
                TypesClass::Depot()->value
            ]);
            $table->integer('solde_Xpress_restant');

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
