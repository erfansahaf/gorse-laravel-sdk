<?php

namespace Erfansahaf\GorseLaravel\Facades;

use Erfansahaf\GorseLaravel\GorseClient;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin GorseClient
 */
class Gorse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GorseClient::class;
    }
}
