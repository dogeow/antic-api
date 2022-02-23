<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return [
            'place' => [
                [
                    'name' => '漳州',
                    'floorNumber' => 3,
                ],
                [
                    'name' => '泉州',
                    'floorNumber' => 3,
                ],
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Goods $goods): Response
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goods $goods): Response
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goods $goods): Response
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goods $goods): Response
    {
    }
}
