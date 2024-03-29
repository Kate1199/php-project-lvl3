<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $urlId)
    {
        $url = DB::table('urls')->find($urlId);

        if (is_null($url)) {
            return response("not found", 404);
        }

        try {
            $response = Http::get($url->name);
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return redirect(route('urls.show', ['url' => $urlId]));
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

        return redirect(route('urls.show', ['url' => $urlId]));
    }
}
