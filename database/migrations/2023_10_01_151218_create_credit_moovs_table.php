<?php

use App\Enums\TypesClass;
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
        Schema::create('credit_moovs', function (Blueprint $table) {
            $table->id();
            $table->integer('Montant');
            $table->integer('Numéro_telephone');
            $table->enum('Type_operation',[
                TypesClass::CreditSimple()->value,
                TypesClass::Forfait_appel()->value,
                TypesClass::Forfait_internet()->value,
            ]);

            $table->unsignedBigInteger('solde_credit_moov_id');
            $table->foreign('solde_credit_moov_id')->references('id')->on('solde_credit_moovs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_moovs');
    }
};
