<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

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
    return view('app');
});

Route::post('/urls/{id}/checks', function ($id) {
    $url = DB::table('urls')->find($id);

    try {
        $response = Http::get($url->name);
    } catch (ConnectionException $e) {
        flash($e->getMessage(), 'danger');
        return redirect()->action([UrlController::class, 'show'], ['url' => $id]);
    }

    DB::table('url_checks')->insert([
        'url_id' => $url->id,
        'status_code' => $response->status(),
        'created_at' => Carbon::now()
    ]);

    return redirect()->action([UrlController::class, 'show'], ['url' => $id]);
})->name('urls.checks');

Route::resources([
    'urls' => UrlController::class
]);
