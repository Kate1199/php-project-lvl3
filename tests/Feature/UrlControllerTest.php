<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    private $faker;
    private $urls;

    public function setUp(): void
    {
        parent::setUp();
        DB::table('urls')->truncate();

        $faker = \Faker\Factory::create();
        $this->urls = [];

        for ($i = 0; $i < 3; $i++) {
            $name = $faker->unique->url;
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

        $url = [
            'url' => [
                'name' => $faker->url()
            ]
            // 'created_at' =>
            //     $faker->date($format = 'Y-m-d', $max = 'now') .  " " . $faker->time($format = 'H:i:s', $max = 'now')
        ];

        $response = $this->post(route('urls.store'), $url);
        $response->assertRedirect(route('urls.show', ['url' => 4]));

        $this->assertDatabaseHas('urls', $url['url']);
    }

    public function testShow()
    {
        $this->assertDatabaseHas('urls', $this->urls[0]);
        $this->assertDatabaseHas('urls', $this->urls[1]);
        $this->assertDatabaseHas('urls', $this->urls[2]);
    }
}
