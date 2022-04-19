<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $url = DB::table('urls')->first();
        $urlId = $url->id;

        Http::fake([
            $url->name => Http::response(
                "<h1>Test</h1>
                <title>Test title</title>
                <meta name=description content='Test description'",
                200
            )
        ]);

        $this->freezeTime(function (Carbon $time) use ($urlId) {
            $urlCheck = [
                'id' => 1,
                'url_id' => $urlId,
                'status_code' => 200,
                'h1' => 'Test',
                'title' => 'Test title',
                'description' => 'Test description',
                'created_at' => Carbon::now()
            ];

            $response = $this->post(route('urls.checks', ['id' => $urlId]));

            $this->assertDatabaseHas('url_checks', $urlCheck);
        });
    }

    public function urlChecksPageDoesNotExistsTest(): void
    {
        $url = DB::table('urls')->first();
        $urlId = $url->id;

        Http::fake([
            $url->name => Http::response(404)
        ]);

        $this->post(route('urls.checks'), ['id' => $urlId]);

        $this->assertNotFound();
        $this->expectException(\Illuminate\Http\Client\ConnectionException::class);
    }
}
