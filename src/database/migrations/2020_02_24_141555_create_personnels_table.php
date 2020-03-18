<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('id_utilisateur');
            $table->unsignedTinyInteger('statut');
            $table->unsignedInteger('rang')->nullable()->unique();
            $table->unsignedSmallInteger('id_ligue')->nullable();
        });

        DB::statement('ALTER TABLE personnels ADD CONSTRAINT chk_statut CHECK(statut BETWEEN 0 AND 3)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personnels');
    }
}
