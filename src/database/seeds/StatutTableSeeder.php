<?php

use App\Enums\ReservationStateEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::createStatut(ReservationStateEnum::UNKNOWN, 'Inconnu');
        self::createStatut(ReservationStateEnum::EXPIRED, 'Expiré');
        self::createStatut(ReservationStateEnum::WAITING, 'En attente');
        self::createStatut(ReservationStateEnum::REFUSED, 'Refusé');
        self::createStatut(ReservationStateEnum::ACTIVE, 'Actif');
    }

    private static function createStatut(int $type, string $nom): void
    {
        $succeed = DB::table('statuts')->insert([
            'id' => $type,
            'nom' => $nom
        ]);
        assert($succeed, "Echec de l'insertion de : '$type, $nom'");
    }
}
