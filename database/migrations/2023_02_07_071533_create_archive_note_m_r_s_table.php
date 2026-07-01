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
        Schema::create('archive_note_m_r_s', function (Blueprint $table) {
            $table->id();
            $table->string('numInscrit', 60);
            $table->timestamps();

            $table->unsignedBigInteger('idNote');
            $table->foreign('idNote')->references('idNote')->on('archive_notes');

            $table->unsignedBigInteger('idMatiereN');
            $table->foreign('idMatiereN')->references('idMatiere')->on('element_constitutifs');

            $table->unsignedBigInteger('idEtdN');
            $table->foreign('idEtdN')->references('idEtd')->on('archive_m_r_s');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archive_note_m_r_s');
    }
};
