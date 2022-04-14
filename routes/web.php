<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

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

    DB::table('url_checks')->insert([
        'url_id' => $url->id, 'created_at' => $url->created_at
    ]);

    return redirect()->action([UrlController::class, 'show'], ['url' => $id]);
})->name('urls.checks');

Route::resources([
    'urls' => UrlController::class
]);
