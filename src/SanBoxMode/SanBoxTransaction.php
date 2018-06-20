<?php

namespace nattaponra\LaraWallet\SanBoxMode;


use Illuminate\Database\Eloquent\Model;

class SanBoxTransaction extends Model
{
    protected $fillable = ["wallet_id","transaction_type","amount"];

    public function __construct(array $attributes = [])
    {
        $this->table = config("larawallet.sanbox_transaction_table","lara_wallet_sanbox_transactions");
        parent::__construct($attributes);
    }

   

}

