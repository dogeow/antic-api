<?php

namespace App\GraphQL\Queries;

class Quote
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     * @return string
     */
    public function __invoke($_, array $args): string
    {
        return (new  \App\Http\Controllers\QuoteController)->random();
    }
}
