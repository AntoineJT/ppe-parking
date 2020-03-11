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
        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('id')
                ->references('id')
                ->on('utilisateurs');
        });
        Schema::table('personnels', function (Blueprint $table) {
            $table->foreign('id')
                ->references('id')
                ->on('utilisateurs');
            $table->foreign('id_ligue')
                ->references('id')
                ->on('ligues');
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('id_personnel')
                ->references('id')
                ->on('personnels');
            $table->foreign('numero_place')
                ->references('numero')
                ->on('places');
            $table->foreign('type_statut')
                ->references('id')
                ->on('statuts');
        });
        Schema::table('lien_reset', function (Blueprint $table) {
            $table->foreign('id_utilisateur')
                ->references('id')
                ->on('utilisateurs');
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
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['id']);
        });
        Schema::table('personnels', function (Blueprint $table) {
            $table->dropForeign(['id']);
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['id_personnel']);
            $table->dropForeign(['numero_place']);
            $table->dropForeign(['type_statut']);
        });
        Schema::table('lien_reset', function (Blueprint $table) {
            $table->dropForeign(['id_utilisateur']);
        });

        Schema::disableForeignKeyConstraints();
    }
}
