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
        Schema::create('element_constitutifs', function (Blueprint $table) {
            $table->id('idMatiere');
            $table->string('matiere')->nullable();
            $table->string('enseignant')->nullable();
            $table->string('parcours', 50)->nullable()->default('Tronc commun');
            $table->float('poids')->nullable();
            $table->integer('statut')->default(1);
            $table->timestamps();

            $table->unsignedBigInteger('idUE');
            $table->foreign('idUE')->references('idUE')->on('unite_enseignements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('element_constitutifs');
    }
};
