<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ExampleController extends Controller
{
    /**
     * @return string[][]
     */
    public function index(): array
    {
        return [
            [
                'name' => 'array',
                'description' => '返回一个数组，10 个元素',
                'url' => '/example/array',
                'content' => '[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]',
            ],
        ];
    }

    public function array(): JsonResponse
    {
        return response()->json([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    }
}
