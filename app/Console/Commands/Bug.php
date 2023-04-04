<?php

namespace App\Console\Commands;

use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\BookmarkSubCategory;
use Illuminate\Console\Command;

class Bug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bug:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $bookCategory = BookmarkCategory::all();
        $bookSubCategory = BookmarkSubCategory::all();

        $bookCategory = array_column($bookCategory->toArray(), 'id', 'name');
        $bookSubCategory = array_column($bookSubCategory->toArray(), 'id', 'name');

        $bookmarks = Bookmark::all();

        foreach ($bookmarks as $bookmark) {
            $bookmark->bookmark_category_id = $bookCategory[$bookmark->category];
            $bookmark->bookmark_sub_category_id = $bookSubCategory[$bookmark->sub_category];
            $bookmark->save();
        }
    }
}
