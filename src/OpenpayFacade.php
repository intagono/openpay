<?php namespace Intagono\Openpay;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Intagono\Cashier\OpenPay
 */
class OpenpayFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'openpay'; }

}
