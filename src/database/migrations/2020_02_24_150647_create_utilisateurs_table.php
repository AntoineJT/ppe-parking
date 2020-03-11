<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->integerIncrements('id');
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('mail', 70)->unique();
            // $table->timestamps();
            $table->char('mdp', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
}
