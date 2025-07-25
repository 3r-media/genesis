<?php

namespace Rrr\Genesis\Facades;

use Illuminate\Support\Facades\Facade;

class Genesis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'genesis';
    }
}
