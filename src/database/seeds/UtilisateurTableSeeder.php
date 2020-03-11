<?php

use App\Models\Admin;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;

class UtilisateurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Utilisateur::create('Test', 'Mdp=Moka123', 'test@test.org');
        assert($user !== null);
        $user->mdp = '$2y$10$sEf9WBDag76gFcl6LV723eBrCf/n8mNbWvHCqDIEsdeGSDUbBSoji'; // Moka123
        assert($user->save());

        $admin = new Admin;
        $admin->id_utilisateur = $user->id;
        assert($admin->save());
    }
}
