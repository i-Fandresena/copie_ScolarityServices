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
        Schema::create('attestations', function (Blueprint $table) {
            $table->id();
            $table->integer('numAttestation');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('numInscrit');
            $table->date('dateNaissance');
            $table->string('lieuNaissance');
            $table->date('dateDelivrance');
            $table->string('anneeUnivers', 50);
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
        Schema::dropIfExists('attestations');
    }
};
