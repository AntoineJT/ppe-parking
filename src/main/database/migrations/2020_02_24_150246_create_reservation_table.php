<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->integerIncrements('id_res');
            // $table->timestamps();
            $table->date('date_demande');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('id_personnel');
            $table->tinyInteger('type_statut');
            $table->string('numero_place', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation');
    }
}
