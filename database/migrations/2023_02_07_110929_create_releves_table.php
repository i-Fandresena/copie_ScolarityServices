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
        Schema::create('releves', function (Blueprint $table) {
            $table->id();
            $table->integer('numReleve');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('numInscrit');
            $table->date('dateNaissance');
            $table->string('lieuNaissance');
            $table->date('dateDelivrance');
            $table->string('anneeUnivers', 50);
            $table->string('niveau', 50);
            $table->string('parcours', 100)->default('Tronc commun');
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
        Schema::dropIfExists('releves');
    }
};
