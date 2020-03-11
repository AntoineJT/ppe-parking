<?php

use App\Models\Statut;
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
        $statut = new Statut;

        $statut->id = $type;
        $statut->nom = $nom;

        assert($statut->save(), "Echec de l'insertion de : '$type, $nom'");
    }
}
