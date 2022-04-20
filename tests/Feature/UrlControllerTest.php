<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $urls;

    public function setUp(): void
    {
        parent::setUp();
        DB::table('urls')->truncate();

        $faker = \Faker\Factory::create();
        $this->urls = [];

        for ($i = 0; $i < 3; $i++) {
            $name = $faker->unique()->url;
            $createdAt = $faker->
                    date($format = 'Y-m-d', $max = 'now') . " " . $faker->time($format = 'H:i:s', $max = 'now');
            $url = [
                'name' => $name,
                'created_at' => $createdAt
            ];

            $this->urls[] = $url;
        }

        DB::table('urls')->insert($this->urls);
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $faker = \Faker\Factory::create();

        $this->freezeTime(function (Carbon $time) use ($faker) {
            $url = [
                'url' => [
                    'name' => $faker->url(),
                    'created_at' => Carbon::now()
                ]
            ];

            $response = $this->post(route('urls.store'), $url);
            $response->assertRedirect(route('urls.show', ['url' => 4]));

            $this->assertDatabaseHas('urls', $url['url']);
        });
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
}
