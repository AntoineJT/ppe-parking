<?php

use App\Enums\UserStateEnum;
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
        self::createUser('Test', 'Mdp=Moka123', 'test@test.org', '$2y$10$sEf9WBDag76gFcl6LV723eBrCf/n8mNbWvHCqDIEsdeGSDUbBSoji');
        self::addToAdmin(DB::table('utilisateurs')->max('id'));

        self::createUser('Test', 'Yolo', 'yolo@test.org', '$2y$10$sEf9WBDag76gFcl6LV723eBrCf/n8mNbWvHCqDIEsdeGSDUbBSoji');
        self::addToPersonnel(DB::table('utilisateurs')->max('id'));
    }

    private static function createUser(string $last_name, string $first_name, string $mail, string $password): void
    {
        $succeed = DB::table('utilisateurs')->insert([
            'nom' => $last_name,
            'prenom' => $first_name,
            'mail' => $mail,
            'mdp' => $password
        ]);
        assert($succeed);
    }

    private static function addToAdmin(int $user_id): void
    {
        $succeed = DB::table('admins')->insert([
            'id_utilisateur' => $user_id
        ]);
        assert($succeed);
    }

    private static function addToPersonnel(int $user_id): void
    {
        $succeed = DB::table('personnels')->insert([
            'id_utilisateur' => $user_id,
            'statut' => UserStateEnum::STATE_ENABLED,
            'rang' => NULL,
            'id_ligue' => 1
        ]);
        assert($succeed);
    }
}
