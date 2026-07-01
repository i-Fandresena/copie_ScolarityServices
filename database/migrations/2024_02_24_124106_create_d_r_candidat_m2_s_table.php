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
        Schema::create('d_r_candidat_m2_s', function (Blueprint $table) {
            $table->id('idEtd')->autoIncrement();
            $table->string('numInscrit', 30)->unique();
            $table->string('nom', 50)->nullable();
            $table->string('prenom', 100)->nullable();
            $table->date('dateNaissance')->nullable();
            $table->string('lieuNaissance', 80)->nullable();
            $table->string('telCandidat', 15)->nullable();
            $table->string('cin', 20)->nullable();
            $table->string('nationalite', 30)->nullable();
            $table->string('anneeUnivers', 15);
            $table->string('genre', 20)->nullable();
            $table->string('parcours')->nullable();
            $table->string('universite')->nullable();
            $table->string('centreExamen', 50)->nullable();
            $table->string('statut', 50)->nullable()->default('Non Fonctionnaire');
            $table->string('etablissement')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->string('situationMat', 50)->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('idDroitE');
            $table->foreign('idDroitE')->references('idDroit')->on('droits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_r_candidat_m2_s');
    }
};
