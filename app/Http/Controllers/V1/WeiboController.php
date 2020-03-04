<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WeiboHot;

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
        return response()->json($query->get());
    }
}
