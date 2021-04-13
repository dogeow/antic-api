<?php

namespace App\GraphQL\Queries;

use App\Models\PostTag;
use Illuminate\Support\Facades\DB;

class TagsCount
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return PostTag::select(['id', 'name', DB::raw('count(*) as count')])->groupBy('name')->get();
    }
}
