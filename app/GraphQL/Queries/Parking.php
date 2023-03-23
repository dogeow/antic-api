<?php

namespace App\GraphQL\Queries;

class Parking
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     * @return array
     */
    public function __invoke($_, array $args): array
    {
        return (new \App\Http\Controllers\ApiController())->parking();
    }
}
