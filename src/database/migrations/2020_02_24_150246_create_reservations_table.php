<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->integerIncrements('id_res');
            // $table->timestamps();
            $table->date('date_demande');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('id_personnel')->unsigned();
            $table->tinyInteger('type_statut')->unsigned();
            $table->string('numero_place', 10);
            $table->bigInteger('rang')->unsigned()->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
