<?php

namespace Erfansahaf\GorseLaravel\Exceptions;

use Exception;

class GorseException extends Exception
{
    public static function missingEndpoint(): self
    {
        return new static('No Gorse endpoint was provided. Please provide an endpoint in the `gorse.endpoint` config key.');
    }
}