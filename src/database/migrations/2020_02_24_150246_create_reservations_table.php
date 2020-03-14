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

            $table->id();
            // $table->timestamps();
            $table->date('date_demande');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedInteger('id_personnel');
            $table->unsignedTinyInteger('type_statut');
            $table->unsignedInteger('id_place');
            $table->unsignedBigInteger('rang')->nullable()->unique();
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
