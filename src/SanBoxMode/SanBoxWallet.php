<?php

namespace nattaponra\LaraWallet\SanBoxMode;

use Illuminate\Database\Eloquent\Model;
use nattaponra\LaraWallet\Eloquent;
use nattaponra\LaraWallet\WalletInterface;

class SanBoxWallet extends Model implements WalletInterface
{
    use Eloquent;

    protected $fillable = ["user_id","balance"];

    public function __construct(array $attributes = [])
    {
        $this->table = config("larawallet.sanbox_wallet_table","lara_wallet_sanbox_wallets");
        parent::__construct($attributes);
    }

    private function isEnough($amount){

        return $this->balance >= $amount;

    }

    public function balance(){

        return $this->balance;
    }

    public function deposit($amount){

        $this->balance += $amount;
        $this->save();

        $this->sanBoxTransactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'deposit',
            'amount'           => $amount
        ]);

        return true;
    }

    public function received($amount){
        
        $this->balance += $amount;
        $this->save();

        $this->sanBoxTransactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'received',
            'amount'           => $amount
        ]);
    }

    public function withdraw($amount){

        if($this->isEnough($amount)){
            $fee = 0;
            $withdrawFee = config("larawallet.withdraw_fee",0);

            if($withdrawFee != 0){
                $fee = $amount * ($withdrawFee/100);
            }

            $this->balance -= $amount - $fee;
            $this->save();

            $this->transactions()->create([
                'wallet_id'        => $this->id,
                'transaction_type' => 'withdraw',
                'amount'           => $amount
            ]);

            if($fee !=0 ){
                $this->fee($fee,"withdraw");
            }

        }


    }

    public function transfer($amount , $toUser){

        if($this->isEnough($amount)) {
            $fee = 0;
            $transferFee = config("larawallet.transfer_fee",0);

            if($transferFee != 0){
                $fee = $amount * ($transferFee/100);
            }

            $this->balance -= $amount - $fee;
            $this->save();

            $this->sanBoxTransactions()->create([
                'wallet_id'        => $this->id,
                'transaction_type' => 'transfer',
                'amount'           => $amount
            ]);

            $toUser->wallet->received($amount);

            if($fee !=0 ){
                $this->fee($fee,"transfer");
            }
        }
    }

    public function fee($amount,$transactionType){

        $this->balance -= $amount;
        $this->save();
        $this->sanBoxTransactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'fee_'.$transactionType,
            'amount'           => $amount
        ]);
    }

}