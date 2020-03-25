<?php

use App\Models\Config;
use App\Utils\TimeManager;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // stocké en minutes
        self::createParameter(Config::EXPIRATION_TIME, TimeManager::unixBeginTime()->addRealDays(1)->timestamp / 60);
    }

    private static function createParameter(string $key, string $value): void
    {
        $parameter = new Config;
        $parameter->key = $key;
        $parameter->value = $value;
        assert($parameter->save());
    }
}
