<?php


namespace nattaponra\LaraWallet\SanBoxMode;


trait HasSanBoxWallet
{
    public function sanBoxWallet()
    {

        $sanBoxWallet = $this->hasOne(SanBoxWallet::class, "user_id", "id");
        if ($sanBoxWallet->count() == 0) {
            $this->initWallet($sanBoxWallet);
            $sanBoxWallet = $this->hasOne(SanBoxWallet::class , "user_id", "id");
        }

        return $sanBoxWallet;
    }
}