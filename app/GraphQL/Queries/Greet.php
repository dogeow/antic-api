<?php

namespace App\GraphQL\Queries;

class Greet
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     * @return string
     */
    public function __invoke($_, array $args): string
    {
        return "Hello, {$args['name']}!";
    }
}
