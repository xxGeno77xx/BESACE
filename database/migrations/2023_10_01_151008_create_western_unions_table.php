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
        Schema::create('western_unions', function (Blueprint $table) {
            $table->id();
            $table->integer('Montant');
            $table->enum('operation',[
                TypesClass::Xpress()->value,
                TypesClass::Tmoney()->value,
                TypesClass::Western()->value,
                TypesClass::FLooz()->value,
                TypesClass::Ria()->value,
            ]) ->default(TypesClass::Western()->value);
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('Type')->default(TypesClass::Retrait()->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('western_unions');
    }
};
