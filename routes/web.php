<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use DiDom\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('newUrl');
});

Route::post('/urls/{id}/checks', function ($id) {
    $url = DB::table('urls')->findOrFail($id);

    try {
        $response = Http::get($url->name);
    } catch (Exception $e) {
        flash($e->getMessage(), 'danger');
        return redirect(route('urls.show', ['url' => $id]));
    }

    $document = new Document($response->body());
    $h1 = optional($document->first('h1'))->text();
    $title = optional($document->first('title'))->text();
    $description = optional($document->first('meta[name="description"]'))->getAttribute('content');

    DB::table('url_checks')->insert([
        'url_id' => $url->id,
        'status_code' => $response->status(),
        'h1' => $h1,
        'title' => $title,
        'description' => $description,
        'created_at' => Carbon::now()
    ]);

    return redirect(route('urls.show', ['url' => $id]));
})->name('urls.checks');

Route::resources([
    'urls' => UrlController::class
]);
