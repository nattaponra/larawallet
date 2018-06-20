<?php


namespace nattaponra\LaraWallet;


trait HasWallet
{
    private function initWallet($wallet)
    {
        $wallet->create([
            'user_id' => $this->id,
            'balance' => config('larawallet.balance_init',0)
        ]);
    }

    public function wallet()
    {

        $wallet = $this->hasOne(Wallet::class, "user_id", "id");

        if ($wallet->count() == 0) {
            $this->initWallet($wallet);
            $wallet = $this->hasOne(Wallet::class , "user_id", "id");
        }

        return $wallet;
    }

  
}