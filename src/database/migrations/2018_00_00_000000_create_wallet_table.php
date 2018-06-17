<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateWalletTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('larawallet.wallet_table',"lara_wallet_wallets"), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->double("balance");
            $table->timestamps();
            $table->foreign('user_id') ->references('id')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('larawallet.wallet_table',"lara_wallet_wallets"));
    }
}