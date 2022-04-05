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

$urlController = new UrlController();

Route::get('/', function () {
    return view('app');
});

Route::resources([
    'urls' => UrlController::class
]);

// Route::get('/url/{id}', function (Request $request, $id) use ($urlController) {
//     $url = $urlController->showById($id);

//     return view('currentUrl', ['url' => $url]);
// })->name('url');

// Route::post('/addUrl', function (Request $request) use ($urlController) {
//     $id = $urlController->storeGetId($request);

//     return redirect()
//         ->route("url", [$id])
//         ->with('success', 'Url created successfully');
// })->name('addNewUrl');

// Route::get('/urls', function () use ($urlController) {
//     $urls = $urlController->showAll();

//     return view('urls')
//         ->with('urls', $urls);
// })->name("urls");
