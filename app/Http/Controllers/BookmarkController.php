<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::join('bookmark_categories', 'bookmark_categories.name', '=', 'bookmarks.category')
            ->join('bookmark_sub_categories', 'bookmark_sub_categories.name', '=', 'bookmarks.sub_category')
            ->orderByDesc('bookmark_categories.order')
            ->orderByDesc('bookmark_sub_categories.order')
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
