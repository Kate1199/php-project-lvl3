<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Database\Seeders\UrlSeeder;

class UrlControllerTest extends TestCase
{
    protected $seeder = UrlSeeder::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
        $this->seed(UrlSeeder::class);
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testShow()
    {
        $response = $this->get(route('urls.show', ['url' => 1]));
        $response->assertOk();

        $response = $this->get(route('urls.show', ['url' => 2]));
        $response->assertOk();

        $response = $this->get(route('urls.show', ['url' => 3]));
        $response->assertOk();
    }

    public function testStore()
    {
        $faker = \Faker\Factory::create();

        $this->freezeTime(function (Carbon $time) use ($faker) {
            $url = [
                'url' => [
                    'name' => "https://" . $faker->domainName(),
                    'created_at' => Carbon::now()
                ]
            ];

            $response = $this->post(route('urls.store'), $url);
            $response->assertRedirect(route('urls.show', ['url' => 4]));

            $this->assertDatabaseHas('urls', $url['url']);
        });
    }
}
