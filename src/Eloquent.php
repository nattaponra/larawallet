<?php


namespace nattaponra\LaraWallet;


use App\Transaction;

trait Eloquent
{
    public function transactions()
    {
        return $this->hasMany( Transaction::class);
    }


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}