<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WeiboHot;
use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class WeiboController extends Controller
{
    public function index()
    {
        $date = request('date');

        $query = WeiboHot::query()->when($date, function ($query) use ($date) {
            $query->whereDate('updated_at', $date);
        })->when($date === null, function ($query) {
            $query->whereDate('updated_at', Carbon::today());
        })->orderByDesc('updated_at');

        return $query->jsonPaginate(20);
    }

    #[ArrayShape(['total' => 'int', 'startDate' => 'string', 'endDate' => 'string'])]
    public function about(): array
    {
        return [
            'total' => WeiboHot::count(),
            'startDate' => WeiboHot::min('created_at'),
            'endDate' => WeiboHot::max('created_at'),
        ];
    }
}
