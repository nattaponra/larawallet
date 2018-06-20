<?php

namespace nattaponra\LaraWallet;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use nattaponra\LaraWallet\Exception\LaraWalletException;


class Wallet extends Model implements WalletInterface
{
    use Eloquent;

    protected $fillable = ["user_id","balance"];

    public function __construct(array $attributes = [])
    {
        $this->table = config("larawallet.wallet_table","lara_wallet_wallets");
        parent::__construct($attributes);
    }

    private function isEnough($amount){

        return $this->balance >= $amount;
    }

    public function balance(){

        return $this->balance;
    }

    public function deposit($amount){

        DB::beginTransaction();

        try{

            $this->balance += $amount;
            $this->save();

            $this->transactions()->create([
                'transaction_type' => 'deposit',
                'amount'           => $amount
            ]);

            DB::commit();
            return true;

        }catch (LaraWalletException $e){

            DB::rollback();
            return false;

        }

    }

    private function received($amount){

        $this->balance += $amount;
        $this->save();

        $this->transactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'received',
            'amount'           => $amount
        ]);
    }

    public function withdraw($amount){

        if($this->isEnough($amount)){

            DB::beginTransaction();

            try{

                $fee = 0;
                $withdrawFee = config("larawallet.withdraw_fee",0);

                if($withdrawFee != 0){
                    $fee = $amount * ($withdrawFee/100);
                }

                $this->balance -= $amount - $fee;
                $this->save();

                $this->transactions()->create([
                    'transaction_type' => 'withdraw',
                    'amount'           => $amount
                ]);

                if($fee !=0 ){
                    $this->fee($fee,'withdraw');
                }

                DB::commit();
                return true;


            }catch (LaraWalletException $e){
                DB::rollback();
            }

        }
        return false;

    }

    public function transfer($amount , $toUser){

        if($this->isEnough($amount)) {

            DB::beginTransaction();

            try{

                if(!$toUser instanceof User){
                   throw new Exception("Transferee not found.");
                }

                $fee = 0;
                $transferFee = config("larawallet.transfer_fee",0);

                if($transferFee != 0){
                    $fee = $amount * ($transferFee/100);
                }

                $this->balance -= $amount - $fee;
                $this->save();

                $this->transactions()->create([
                    'transaction_type' => 'transfer',
                    'amount'           => $amount
                ]);

                $toUser->wallet->received($amount);

                if($fee !=0 ){
                    $this->fee($fee,'transfer');
                }

                DB::commit();
                return true;

            }catch (LaraWalletException $e){
                DB::rollback();
            }

        }

        return false;
    }

    public function fee($amount,$transactionType){

        $this->balance -= $amount;
        $this->save();
        $this->transactions()->create([
            'transaction_type' => 'fee_'.$transactionType,
            'amount'           => $amount
        ]);
    }


}