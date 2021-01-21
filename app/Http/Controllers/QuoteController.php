<?php

namespace App\Http\Controllers;

use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        return Quote::all();
    }

    public function random()
    {
        return Quote::all()->random(1)->first()->content;
    }
}
