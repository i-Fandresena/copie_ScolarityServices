<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droits', function (Blueprint $table) {
            $table->id('idDroit');
            $table->string('typeDroit',5)->unique();
            $table->string('designation');
            $table->integer('montantDroit');
            $table->string('role');
            $table->string('createdBy', 50)->nullable();
            $table->string('udatedBy', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('droits');
    }
};
