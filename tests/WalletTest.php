<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LaraWalletTest extends TestCase
{



    public function testInitialWallet()
    {
        $clear = function(){
            User::where("email","testing@feedika.com")->delete();
        };

        $newUser = [
            "name"                  => "user",
            "email"                 => "testing@feedika.com",
            "password"              => "1234",
            "password_confirmation" => "1234",

        ];

        try{

            $user = User::create($newUser);

            $balanceInit = config("larawallet.balance_init",0);

            $this->assertEquals($balanceInit,$user->wallet->balance());

        }finally{
            $clear();
        }

    }


    public function testDepositWallet(){

        $clear = function(){
            User::where("email","testing@feedika.com")->delete();
        };

        $newUser = [
            "name"                  => "user",
            "email"                 => "testing@feedika.com",
            "password"              => "1234",
            "password_confirmation" => "1234",

        ];

        try{

            $user = User::create($newUser);

            $user->wallet->deposit(100);
            $this->assertEquals(100,$user->wallet->balance());


            $user->wallet->deposit(0);
            $this->assertEquals(100,$user->wallet->balance());


            $user->wallet->deposit(50);
            $this->assertEquals(150,$user->wallet->balance());


        }finally{
            $clear();
        }


    }


    public function testWithdrawWallet(){

        $clear = function(){
            User::where("email","testing@feedika.com")->delete();
        };

        $newUser = [
            "name"                  => "user",
            "email"                 => "testing@feedika.com",
            "password"              => "1234",
            "password_confirmation" => "1234",

        ];

        try{

            $user = User::create($newUser);
            $withdrawFee = config("larawallet.withdraw_fee",0);



            $user->wallet->deposit(10000);
            $user->wallet->withdraw(10000);
            $this->assertEquals(0,$user->wallet->balance());


            $user->wallet->deposit(10000);
            $user->wallet->withdraw(10001);
            $this->assertEquals(10000,$user->wallet->balance());


            $user->wallet->withdraw(5000);
            $this->assertEquals(5000,$user->wallet->balance());

        }finally{
            $clear();
        }


    }

    public function testTransferWallet(){

        $clear = function(){
            User::where("email","testing1@feedika.com")->delete();
            User::where("email","testing2@feedika.com")->delete();
        };

        $newUser1 = [
            "name"                  => "user1",
            "email"                 => "testing1@feedika.com",
            "password"              => "1234",
            "password_confirmation" => "1234",

        ];

        $newUser2 = [
            "name"                  => "user2",
            "email"                 => "testing2@feedika.com",
            "password"              => "1234",
            "password_confirmation" => "1234",

        ];


        try{


            $user1 = User::create($newUser1);
            $user2 = User::create($newUser2);

            //Initial wallet
            $this->assertEquals(0, $user1->wallet->balance());
            $this->assertEquals(0, $user2->wallet->balance());

            //Deposit 15000
            $user1->wallet->deposit(15000);
            $user1->wallet->transfer(1000,$user2);


            $this->assertEquals(14000, $user1->wallet->balance());
            $this->assertEquals(1000, $user2->wallet->balance());


            $user2->wallet->transfer(2000,$user1);
            $this->assertEquals(1000, $user2->wallet->balance());
            $this->assertEquals(14000, $user1->wallet->balance());


            $user2->wallet->transfer(100,$user1);
            $this->assertEquals(900, $user2->wallet->balance());
            $this->assertEquals(14100, $user1->wallet->balance());


        }finally{
            $clear();
        }


    }
}
