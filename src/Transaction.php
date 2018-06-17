<?php

namespace nattaponra\LaraWallet;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ["wallet_id","transaction_type","amount"];

    public function __construct(array $attributes = [])
    {
        $this->table = config("larawallet.transaction_table","lara_wallet_transactions");
        parent::__construct($attributes);
    }

   

}

