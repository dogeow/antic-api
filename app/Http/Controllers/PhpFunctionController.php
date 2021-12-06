<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PhpFunction;
use App\Models\PhpFunctionCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PhpFunctionController extends Controller
{
    public function index(Request $request): Collection | array
    {
        $query = PhpFunction::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'LIKE', '%'.$request->search.'%')
                ->orWhere('intro', 'LIKE', '%'.$request->search.'%');
        });
        $functions = QueryBuilder::for($query)->allowedFilters(['name', 'intro'])->get();

        if (empty($functions)) {
            return [];
        }

        $categories = PhpFunctionCategory::all();
        foreach ($functions as &$function) {
            $function['category'] = $categories[$function['category_id'] - 1]['name'];
        }

        return $functions;
    }
}
