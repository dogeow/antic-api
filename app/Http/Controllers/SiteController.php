<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Database\Eloquent\Collection;

class SiteController extends Controller
{
    public function index(): array
    {
        return [
            'sites' => Site::select(['id', 'domain', 'online', 'last_updated_at'])->with('todayLatest')->get(),
        ];
    }

    public function check(): Collection
    {
        $site = Site::where('domain', 'huodj.com')->firstOrFail();
        $history = $site->history()->whereDate('created_at', date('Y-m-d'))->get();

        foreach ($history as $item) {
            $item->humans = date('H:i', strtotime((string) $item->created_at));
        }

        return $history;
    }
}
