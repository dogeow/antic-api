<?php

namespace Tests\Feature;

use App\Http\Controllers\AboutMeController;
use Tests\TestCase;

class AboutMeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample(): void
    {
        self::assertIsArray((new AboutMeController)->index());
    }
}
