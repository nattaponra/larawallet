<?php
namespace nattaponra\LaraWallet;


interface WalletInterface
{
    public function balance();
    public function deposit($amount);
    public function withdraw($amount);
    public function transfer($amount , $toUser);
    public function fee($amount,$transactionType);
}