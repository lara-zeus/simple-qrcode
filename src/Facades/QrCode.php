<?php

namespace LaraZeus\QrCode\Facades;

use Illuminate\Support\Facades\Facade;
use LaraZeus\QrCode\Generator;

class QrCode extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        self::clearResolvedInstance(Generator::class);

        return Generator::class;
    }
}
