<?php

namespace nattaponra\LaraWallet;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{


    protected $fillable = ["user_id","balance"];

    public function __construct(array $attributes = [])
    {
        $this->table = config("larawallet.wallet_table","lara_wallet_wallets");
        parent::__construct($attributes);
    }


    public function balance(){
        return $this->balance;
    }

    public function deposit($amount){

        $this->balance += $amount;
        $this->save();

        $this->transactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'deposit',
            'amount'           => $amount
        ]);
    }

    public function received($amount){
        $this->balance += $amount;
        $this->save();

        $this->transactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'received',
            'amount'           => $amount
        ]);
    }

    public function withdraw($amount){

        $this->balance -= $amount;
        $this->save();

        $this->transactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'withdraw',
            'amount'           => $amount
        ]);
    }

    public function transfer($amount , $toUser){

        $this->balance -= $amount;
        $this->save();

        $this->transactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'transfer',
            'amount'           => $amount
        ]);

        $toUser->wallet->received($amount);

    }



    public function transactions()
    {
        return $this->hasMany( Transaction::class);
    }


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}