<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligues', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->smallIncrements('id');
            // $table->timestamps();
            $table->string('nom', 50)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligues');
    }
}
