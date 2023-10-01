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
        Schema::create('floozs', function (Blueprint $table) {
            $table->id();
            $table->integer('Montant');
            $table->integer('Commission');
            $table->string('Téléphone');
            $table->enum('Type',[
                TypesClass::Retrait()->value,
                TypesClass::Depot()->value
            ]);

            $table->unsignedBigInteger('solde_flooz_id');
            $table->foreign('solde_flooz_id')->references('id')->on('solde_floozs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floozs');
    }
};
