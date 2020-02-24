<?php

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
        $table = DB::table('statut');
        $table->insert([
            'type_statut' => 0,
            'nom_statut' => 'Inconnu'
        ]);
        $table->insert([
            'type_statut' => 1,
            'nom_statut' => 'Expiré'
        ]);
        $table->insert([
            'type_statut' => 2,
            'nom_statut' => 'En attente'
        ]);
        $table->insert([
            'type_statut' => 3,
            'nom_statut' => 'Refusé'
        ]);
    }
}
