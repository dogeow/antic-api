<?php

namespace App\Http\Controllers;

use App\Models\WeiboHot;
use Carbon\Carbon;

class WeiboController extends Controller
{
    public function index()
    {
        $date = request('date');
        $query = WeiboHot::query();
        if ($date) {
            $query::whereDate('updated_at', $date);
        } else {
            $query::whereDate('updated_at', Carbon::today());
        }
        $query::orderBy('updated_at', 'DESC');

        return $query::jsonPaginate(20);
    }

    public function about(): array
    {
        return [
            'total' => WeiboHot::count(),
            'startDate' => WeiboHot::min('created_at'),
            'endDate' => WeiboHot::max('created_at'),
        ];
    }
}
