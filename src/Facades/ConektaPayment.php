<?php

namespace AlxFavela\ConektaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class ConektaPayment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'conektapayment';
    }
}
