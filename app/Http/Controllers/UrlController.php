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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'url.name' => 'required|unique:urls,name|max:255|url'
        ]);
        $data['url']['created_at'] = Carbon::now();

        flash("Страница успешно добавлена")->success();

        $id = DB::table('urls')->insertGetId([
            'name' => $data['url']['name'],
            'created_at' => $data['url']['created_at']
        ]);

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
