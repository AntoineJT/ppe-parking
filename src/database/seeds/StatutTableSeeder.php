<?php

use App\Models\Statut;
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
        self::createStatut(0, 'Inconnu');
        self::createStatut(1, 'Expiré');
        self::createStatut(2, 'En attente');
        self::createStatut(3, 'Refusé');
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
