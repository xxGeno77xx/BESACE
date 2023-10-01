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
        Schema::create('credit_togocells', function (Blueprint $table) {
            $table->id();
            $table->integer('Montant');
            $table->integer('Numéro_telephone');
            $table->enum('Type_operation',[
                TypesClass::CreditSimple()->value,
                TypesClass::Forfait_appel()->value,
                TypesClass::Forfait_internet()->value,
            ]);

            $table->unsignedBigInteger('solde_credit_togocell_id');
            $table->foreign('solde_credit_togocell_id')->references('id')->on('solde_credit_togocells');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_togocells');
    }
};
