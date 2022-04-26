<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $urls = [];

        for ($i = 0; $i < 3; $i++) {
            $name = $faker->unique()->url;
            $createdAt = $faker->
                    date($format = 'Y-m-d', $max = 'now') . " " . $faker->time($format = 'H:i:s', $max = 'now');
            $url = [
                'name' => $name,
                'created_at' => $createdAt
            ];

            $urls[] = $url;
        }

        DB::table('urls')->insert($urls);
    }
}
