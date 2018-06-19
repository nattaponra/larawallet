<?php

namespace nattaponra\LaraWallet;

use Illuminate\Support\Facades\Facade;
/**
 * @see \Nattaponra\LaraWallet\WalletFacade
 */
class WalletFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaraWallet';
    }
}