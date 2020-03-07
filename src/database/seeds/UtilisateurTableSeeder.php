<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UtilisateurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('utilisateur')->insert([
            'id' => 0,
            'nom' => 'Test',
            'prenom' => 'Mdp=Moka123',
            'mail' => 'test@test.org',
            'mdp' => '$2y$10$sEf9WBDag76gFcl6LV723eBrCf/n8mNbWvHCqDIEsdeGSDUbBSoji' // Moka123
        ]);
        DB::table('admin')->insert(['id' => 1]);
    }
}
