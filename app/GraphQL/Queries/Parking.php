<?php

namespace App\GraphQL\Queries;

use App\Http\Controllers\ApiController;

class Parking
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     * @return array
     */
    public function __invoke($_, array $args): array
    {
        return (new ApiController())->parking();
    }
}
