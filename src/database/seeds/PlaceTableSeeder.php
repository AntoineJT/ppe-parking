<?php

use Illuminate\Database\Seeder;

class PlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::createPlace('K3242');
        self::createPlace('J7892');
    }

    private static function createPlace(string $numero): void
    {
        $succeed = DB::table('places')->insert([
            'numero' => $numero,
            'disponible' => true
        ]);
        assert($succeed);
    }
}
