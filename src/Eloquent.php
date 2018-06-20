<?php

namespace nattaponra\LaraWallet;



use App\User;
use nattaponra\LaraWallet\SanBoxMode\SanBoxTransaction;



trait Eloquent
{
    public function transactions()
    {
        return $this->hasMany( Transaction::class);
    }

    public function sanBoxTransactions()
    {
        return $this->hasMany( SanBoxTransaction::class,"wallet_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}