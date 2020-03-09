<?php

use App\Models\StatutModel;
use Illuminate\Database\Seeder;

class StatutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::createStatut(0, 'Inconnu');
        self::createStatut(1, 'Expiré');
        self::createStatut(2, 'En attente');
        self::createStatut(3, 'Refusé');
    }

    private static function createStatut(int $type, string $nom): void
    {
        $statut = new StatutModel;

        $statut->type_statut = $type;
        $statut->nom_statut = $nom;

        assert($statut->save(), "Echec de l'insertion de : '$type, $nom'");
    }
}
