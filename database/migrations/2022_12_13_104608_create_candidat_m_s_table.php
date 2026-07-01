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
        Schema::create('candidat_m_s', function (Blueprint $table) {
            $table->id('idEtd')->autoIncrement();
            $table->string('numInscrit', 30)->unique();
            $table->string('nom', 50);
            $table->string('prenom', 100)->nullable();
            $table->date('dateNaissance')->nullable();
            $table->string('lieuNaissance', 80)->nullable();
            $table->string('telCandidat', 100)->nullable();
            $table->string('cin', 20)->nullable();
            $table->string('nationalite', 20)->nullable();
            $table->string('anneeUnivers', 15)->nullable();
            $table->string('genre', 20)->nullable();
            $table->string('parcours')->nullable();
            $table->string('universite')->nullable();
            $table->string('centreExamen', 50)->nullable();
            $table->string('statut')->nullable()->default('Non Fonctionnaire');
            $table->string('etablissement')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->string('situationMat', 50)->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('idBrdC');
            $table->foreign('idBrdC')->references('idBrd')->on('bordereaus');

            $table->unsignedBigInteger('idDroitC');
            $table->foreign('idDroitC')->references('idDroit')->on('droits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidat_m_s');
    }
};
