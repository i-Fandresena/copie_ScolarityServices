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
        Schema::create('bordereaus', function (Blueprint $table) {
            $table->id('idBrd');
            $table->string('referenceBrd1', 50)->unique();
            $table->string('referenceBrd2', 50)->nullable()->unique();
            $table->integer('montantBrd1');
            $table->integer('montantBrd2')->nullable();
            $table->date('dateBrd1');
            $table->date('dateBrd2')->nullable();
            $table->string('agenceBrd1',10)->nullable()->default('B.O.A');
            $table->string('agenceBrd2', 10)->nullable()->default('B.O.A');
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
        Schema::dropIfExists('bordereaus');
    }
};
