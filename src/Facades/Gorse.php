<?php

namespace Erfansahaf\GorseLaravelSDK\Facades;

use Erfansahaf\GorseLaravelSDK\GorseClient;
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
