<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatutTableSeeder::class);
        $this->call(LigueTableSeeder::class);

        if (env('APP_DEBUG')) {
            $this->call(UtilisateurTableSeeder::class);
        }
    }
}
