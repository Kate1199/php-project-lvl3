<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        DB::table('urls')->truncate();
        DB::table('url_checks')->truncate();

        $faker = \Faker\Factory::create();

        $name = $faker->unique->url;
        $createdAt = $faker->
                date($format = 'Y-m-d', $max = 'now') . " " . $faker->time($format = 'H:i:s', $max = 'now');
        $url = [
            'name' => $name,
            'created_at' => $createdAt
        ];

        DB::table('urls')->insert($url);
    }

    /**
     * A url.cheks feature test.
     *
     * @return void
     * @test
     */
    public function urlChecksTest(): void
    {
        $faker = \Faker\Factory::create();

        $url = DB::table('urls')->first();
        $urlId = $url->id;

        $this->freezeTime(function (Carbon $time) use ($urlId) {
            $urlCheck = [
                'id' => 1,
                'url_id' => $urlId,
                'status_code' => null,
                'h1' => null,
                'title' => null,
                'description' => null,
                'created_at' => Carbon::now()
            ];

            $this->post(route('urls.checks', ['id' => $urlId]));

            $this->assertDatabaseHas('url_checks', $urlCheck);
        });
    }
}
