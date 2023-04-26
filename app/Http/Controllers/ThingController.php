<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThingPostRequest;
use App\Models\Thing;
use Illuminate\Http\Request;

class ThingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Thing::with(['tags', 'photos', 'place'])->orderByDesc('id')->jsonPaginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThingPostRequest $request)
    {
        $thing = Thing::create($request->except(['tags', 'photos']));

        $tags = [];
        foreach ($request->tags as $tag) {
            $tags[] = [
                'name' => $tag,
            ];
        }

        $photos = [];
        foreach ($request->photos as $photo) {
            $photos[] = [
                'path' => $photo['url'],
            ];
        }

        $thing->photos()->createMany($photos);
        $thing->tags()->createMany($tags);

        return $thing->load(['tags', 'photos']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\thing  $thing
     * @return \Illuminate\Http\Response
     */
    public function show(thing $thing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\thing  $thing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, thing $thing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\thing  $thing
     * @return \Illuminate\Http\Response
     */
    public function destroy(thing $thing)
    {
        //
    }
}
