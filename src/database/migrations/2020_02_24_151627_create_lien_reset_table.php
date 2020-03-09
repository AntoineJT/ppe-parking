<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLienResetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lien_reset', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->char('lien', 20);
            $table->integer('id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilisateur');
    }
}
