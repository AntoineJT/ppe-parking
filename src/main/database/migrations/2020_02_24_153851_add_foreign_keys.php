<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->foreign('id')
                ->references('id')
                ->on('utilisateur');
        });
        Schema::table('personnel', function (Blueprint $table) {
            $table->foreign('id')
                ->references('id')
                ->on('utilisateur');
        });
        Schema::table('position_file', function (Blueprint $table) {
            $table->foreign('id_res')
                ->references('id_res')
                ->on('reservation');
        });
        Schema::table('reservation', function (Blueprint $table) {
            $table->foreign('id_personnel')
                ->references('id')
                ->on('personnel');
            $table->foreign('numero_place')
                ->references('numero')
                ->on('place_parking');
            $table->foreign('type_statut')
                ->references('type_statut')
                ->on('statut');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropForeign(['id']);
        });
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropForeign(['id']);
        });
        Schema::table('position_file', function (Blueprint $table) {
            $table->dropForeign(['id_res']);
        });
        Schema::table('reservation', function (Blueprint $table) {
            $table->dropForeign(['id_personnel']);
            $table->dropForeign(['numero_place']);
            $table->dropForeign(['type_statut']);
        });

        Schema::disableForeignKeyConstraints();
    }
}
