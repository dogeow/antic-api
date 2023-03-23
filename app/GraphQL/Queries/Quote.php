<?php

namespace App\GraphQL\Queries;

use App\Http\Controllers\MyStuffController;

class Quote
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args): string
    {
        return (new MyStuffController())->quote();
    }
}
