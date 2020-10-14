<?php

namespace App\Http\Controllers;

use App\Models\PoweredBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class PoweredByController extends Controller
{
    public function index(Request $request)
    {
        $params = ['name', 'category', 'note'];
        $query = PoweredBy::when($request->search, function ($query) use ($request) {
            return $query->where(DB::raw('concat_ws(name, note)'), 'like', '%'.$request->search.'%');
        });

        return QueryBuilder::for($query)
            ->allowedFilters($params)->jsonPaginate(request('size'));
    }
}
