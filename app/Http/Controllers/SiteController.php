<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Carbon;

class SiteController extends Controller
{
    public function index()
    {
        return response()->json([
            'sites' => Site::with('todayLatest')->get()
        ]);
    }

    public function check()
    {
        $site = Site::where('domain', 'huodj.com')->first();
        $history = $site->history()->whereDate('created_at', date('Y-m-d'))->get();

        foreach ($history as &$item) {
            $item->humans = date('H:i', strtotime($item->created_at));
        }

        return response()->json($history);
    }
}
