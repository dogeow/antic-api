<?php

namespace App\Http\Controllers;

use App\Models\ThingTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tags = ThingTag::query()->selectRaw('name, COUNT(*) as count')->groupBy('name')->get();

        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThingTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(ThingTag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThingTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThingTag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThingTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThingTag $tag)
    {
        //
    }
}
