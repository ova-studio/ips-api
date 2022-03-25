<?php

namespace OvaStudio\IpsApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OvaStudio\IpsApi\Skeleton\SkeletonClass
 */
class IpsApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ips-api';
    }
}
