<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    public function storeGetId(Request $request): int
    {
        $data = $request->validate([
            'url.name' => 'required|unique:urls,name|max:255|url'
        ]);
        $data['url']['created_at'] = Carbon::now();

        flash("Страница успешно добавлена")->success();

        return DB::table('urls')->insertGetId([
            'name' => $data['url']['name'],
            'created_at' => $data['url']['created_at']
        ]);
    }

    public function showById(int $id)
    {
        return DB::table('urls')->find($id);
    }

    public function showAll(): array
    {
        return DB::table('urls')->get()->toArray();
    }
}
