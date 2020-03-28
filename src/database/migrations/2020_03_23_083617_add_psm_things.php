<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPsmThings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        self::assertQuery('DROP PROCEDURE IF EXISTS REFRESH_AVAILABILITIES');
        self::assertQuery('
            CREATE PROCEDURE REFRESH_AVAILABILITIES()
            BEGIN
                -- Marque les réservations actives expirées comme expirées
                UPDATE reservations SET type_statut = 1 WHERE type_statut = 4 AND date_expiration < NOW();
                -- Marque les réservactions en attente expirées comme refusées
                UPDATE reservations SET type_statut = 3 WHERE type_statut = 2 AND date_expiration < NOW();
            END
        ');

        self::assertQuery('DROP PROCEDURE IF EXISTS FAST_REFRESH_AVAILABILITIES');
        self::assertQuery('
            CREATE PROCEDURE FAST_REFRESH_AVAILABILITIES()
            BEGIN
                -- Rend disponible les places de réservations actives expirées
                UPDATE places SET disponible = true WHERE id IN (SELECT id_place FROM reservations WHERE type_statut = 4 AND date_expiration < NOW());

                CALL REFRESH_AVAILABILITIES();
            END
        ');

        self::assertQuery('DROP PROCEDURE IF EXISTS FULL_REFRESH_AVAILABILITIES');
        self::assertQuery('
            CREATE PROCEDURE FULL_REFRESH_AVAILABILITIES()
            BEGIN
                -- Rend toutes les places disponibles
                UPDATE places SET disponible = true;

                CALL REFRESH_AVAILABILITIES();
                -- Marque indisponibles les places faisant l\'objet d\'une réservation active
                UPDATE places SET disponible = false WHERE id IN (SELECT id_place FROM reservations WHERE type_statut = 4);
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        self::assertQuery('DROP PROCEDURE REFRESH_AVAILABILITIES');
        self::assertQuery('DROP PROCEDURE FAST_REFRESH_AVAILABILITIES');
        self::assertQuery('DROP PROCEDURE FULL_REFRESH_AVAILABILITIES');
    }

    private static function assertQuery(string $query)
    {
        return assert(DB::unprepared($query));
    }
}
