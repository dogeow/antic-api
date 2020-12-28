<?php

namespace App\Http\Controllers;

use App\Models\PoweredBy;
use Illuminate\Http\Request;
use App\Models\PhpFunction;
use App\Models\PhpFunctionCategory;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class PHPFunctionController extends Controller
{
    /**
     * @return array
     */
    public function index(Request $request)
    {
        $query = PhpFunction::when($request->search, function ($query) use ($request) {
            return $query->where(DB::raw('concat_ws(name, intro)'), 'like', '%'.$request->search.'%');
        });
        $function = QueryBuilder::for($query)->allowedFilters(['name', 'intro'])->first()->toArray();
        $categories = PhpFunctionCategory::where('id', $function['category_id'])->first()->value('name');
        $function['category'] = $categories;

        return $function;
    }
}
