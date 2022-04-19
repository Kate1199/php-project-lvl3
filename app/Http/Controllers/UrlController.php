<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls');

        $latestChecks = DB::table('url_checks')
                ->select('url_id', DB::raw('MAX(created_at) as last_check_created_at'), 'status_code')
                ->groupBy('url_id', 'status_code');

        $urls = DB::table('urls')
                ->leftJoinSub($latestChecks, 'latest_checks', function ($join) {
                    $join->on('urls.id', '=', 'latest_checks.url_id');
                })->get();

        return view('urls')
            ->with('urls', $urls);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'url.name' => 'required|max:255|url'
        ]);
        $data['url']['created_at'] = Carbon::now();

        $rowsWithSameName = DB::table('urls')->where('name', $data['url']['name']);
        if ($rowsWithSameName->count() !== 0) {
            flash("Cтраница уже существует")->important();
            $id = optional($rowsWithSameName->first())->id;
        } else {
            $id = DB::table('urls')->insertGetId([
                'name' => $data['url']['name'],
                'created_at' => $data['url']['created_at']
            ]);

            flash("Страница успешно добавлена")->success();
        }

        return redirect()->route("urls.show", ['url' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = DB::table('urls')->find($id);
        $urlChecks = DB::table('url_checks')->where('url_id', $id)->get();

        return view('currentUrl', ['url' => $url, 'urlChecks' => $urlChecks]);
    }
}
