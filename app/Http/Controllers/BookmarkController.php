<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::select(['category', 'sub_category', 'title', 'url'])
            ->orderByDesc('order')
            ->get();

        $result = [];
        foreach ($bookmarks as $bookmark) {
            $result[$bookmark->category][$bookmark->sub_category][] = [
                'title' => $bookmark->title,
                'url' => $bookmark->url,
            ];
        }

        return $result;
    }

    public function create(Request $request)
    {
        return Bookmark::create($request->all());
    }
}
