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
        Schema::create('note_l2_s', function (Blueprint $table) {
            $table->id();
            $table->string('numInscrit', 60);
            $table->timestamps();

            $table->unsignedBigInteger('idNote');
            $table->foreign('idNote')->references('idNote')->on('notes');

            $table->unsignedBigInteger('idMatiereN');
            $table->foreign('idMatiereN')->references('idMatiere')->on('element_constitutifs');

            $table->unsignedBigInteger('idEtdN');
            $table->foreign('idEtdN')->references('idEtd')->on('licence_twos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_l2_s');
    }
};
