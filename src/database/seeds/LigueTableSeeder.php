<?php

use App\Models\Ligue;
use Illuminate\Database\Seeder;

class LigueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::createLigue('Escrime');
        self::createLigue("Tir à l'arc");
        self::createLigue('Airsoft');
        self::createLigue('Baseball');
        self::createLigue('Football américain');
        self::createLigue('Football');
        self::createLigue('Rugby');
    }

    private static function createLigue(string $name): void {
        $ligue = new Ligue;
        $ligue->nom = $name;
        assert($ligue->save());
    }
}
