<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGevangene extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gevangenes', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('adres');
            $table->string('plaats');
            $table->string('postcode');
            $table->string('bsn');
            $table->string('lengte');
            $table->string('foto');
            $table->string('cel_nummer');
            $table->string('vorige_cel_nummer');
            $table->string('datum_arrestatie');
            $table->string('wanneer_cel');
            $table->string('tot_wanneer_cel');
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
        Schema::dropIfExists('gevangenes');
    }
}
