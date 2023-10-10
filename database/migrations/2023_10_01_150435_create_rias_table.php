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
        Schema::create('rias', function (Blueprint $table) {
            $table->id();
            $table->json('Montant');
            $table->integer('remboursement')->nullable();
            $table->integer('Commission');
            $table->enum('operation',[
                TypesClass::Xpress()->value,
                TypesClass::Tmoney()->value,
                TypesClass::Western()->value,
                TypesClass::FLooz()->value,
                TypesClass::Ria()->value,
            ])  ->default(TypesClass::Ria()->value);
            $table->string('Type')->default(TypesClass::Retrait()->value);
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rias');
    }
};
