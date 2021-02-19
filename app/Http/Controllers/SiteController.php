<?php

namespace App\Http\Controllers;

use App\Models\Site;

class SiteController extends Controller
{
    public function index()
    {
        return [
            'sites' => Site::with('todayLatest')->get(),
        ];
    }

    public function check()
    {
        $site = Site::where('domain', 'huodj.com')->firstOrFail();
        $history = $site->history()->whereDate('created_at', date('Y-m-d'))->get();

        foreach ($history as &$item) {
            $item->humans = date('H:i', strtotime($item->created_at));
        }

        return $history;
    }
}
