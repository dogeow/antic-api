<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\WeiboHot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeiboController extends Controller
{
    public function index($number = null)
    {
        $date = request('date');
        $query = WeiboHot::query();
        if ($date) {
            $query->whereDate('created_at', $date);
        } else {
            $query->whereDate('created_at', Carbon::today());
        }
        $query->orderBy('updated_at', 'DESC');
        if ($number) {
            $query->take($number);
        }

        return $query->get();
    }

    public function about()
    {
        return [
            'total' => WeiboHot::count(),
            'startDate' => WeiboHot::min('created_at'),
            'endDate' => WeiboHot::max('created_at'),
        ];
    }
}
