<?php

namespace App\Http\Controllers;

use App\Models\ThingPhoto;
use Illuminate\Http\Request;

class ThingPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ThingPhoto::query()->select(['id', 'thing_id', 'path'])->distinct()->jsonPaginate();
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
     * @param  \App\Models\ThingPhoto  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(ThingPhoto $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThingPhoto  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThingPhoto $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThingPhoto  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThingPhoto $photo)
    {
        //
    }
}
