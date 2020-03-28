<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// TODO Make WAITING expired reservations state = REFUSED
class AddPsmThings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        assert(DB::unprepared('DROP PROCEDURE IF EXISTS FAST_REFRESH_AVAILABILITIES'));
        assert(DB::unprepared('
            CREATE PROCEDURE FAST_REFRESH_AVAILABILITIES()
            BEGIN
                UPDATE places SET disponible = true WHERE id IN (SELECT id_place FROM reservations WHERE type_statut = 4 AND date_expiration < NOW());
                UPDATE reservations SET type_statut = 1 WHERE type_statut = 4 AND date_expiration < NOW();
            END
        '));

        assert(DB::unprepared('DROP PROCEDURE IF EXISTS FULL_REFRESH_AVAILABILITIES'));
        assert(DB::unprepared('
            CREATE PROCEDURE FULL_REFRESH_AVAILABILITIES()
            BEGIN
                UPDATE places SET disponible = true;
                UPDATE reservations SET type_statut = 1 WHERE type_statut = 4 AND date_expiration < NOW();
                UPDATE places SET disponible = false WHERE id IN (SELECT id_place FROM reservations WHERE type_statut = 4);
            END
        '));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        assert(DB::unprepared('DROP PROCEDURE FAST_REFRESH_AVAILABILITIES'));
        assert(DB::unprepared('DROP PROCEDURE FULL_REFRESH_AVAILABILITIES'));
    }
}
