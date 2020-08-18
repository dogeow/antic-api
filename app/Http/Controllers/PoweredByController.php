<?php

namespace App\Http\Controllers;

use App\Models\PoweredBy;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Pow;
use Illuminate\Support\Facades\DB;

class PoweredByController extends Controller
{
    public function index(Request $request)
    {
        $searchAble = ['name', 'category', 'note', 'link'];
        $query = PoweredBy::query();
        if ($request->search !== null) {
            $query->where(DB::raw("concat_ws(name, note, link)"), 'like', '%'.$request->search.'%');
        }
        if ($request->filters !== null) {
            foreach ($request->filters as $key => $value) {
                if (in_array($key, $searchAble) && $value !== '') {
                    $query->where($key, 'like', '%'.$value.'%');
                }
            }
        }


        return $query->jsonPaginate(request('size'));
    }
}
