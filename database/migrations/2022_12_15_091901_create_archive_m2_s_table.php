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
        Schema::create('archive_m2_s', function (Blueprint $table) {
            $table->id('idEtd');
            $table->string('numInscrit', 30)->unique();
            $table->string('nom', 50)->nullable();
            $table->string('prenom', 100)->nullable();
            $table->date('dateNaissance')->nullable();
            $table->string('lieuNaissance', 80)->nullable();
            $table->string('telCandidat', 100)->nullable();
            $table->string('cin', 20)->nullable();
            $table->string('nationalite', 20)->default('Malagasy');
            $table->string('anneeUnivers', 15);
            $table->string('genre', 20)->nullable();
            $table->string('centreExamen', 25)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('situationMat', 20)->default('Célibataire');
            $table->string('profession', 50)->nullable();
            $table->string('statut', 50)->nullable()->default('Non Fonctionnaire');
            $table->integer('RAD');
            $table->text('observation')->default('RAS')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('idBrdE');
            $table->foreign('idBrdE')->references('idBrd')->on('bordereaus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archive_m2_s');
    }
};
