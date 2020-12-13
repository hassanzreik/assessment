<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operator_countries', function (Blueprint $table) {
            $table->id();
	        $table->unsignedBigInteger('operator_id');
	        $table->unsignedBigInteger('country_id');
            $table->timestamps();
	        $table->foreign('operator_id', 'fk_operator_countries_operators_operator_id')->references('id')->on('operators')->onUpdate('NO ACTION')->onDelete('NO ACTION');
	        $table->foreign('country_id', 'fk_operator_countries_countries_country_id')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operator_countries');
    }
}
