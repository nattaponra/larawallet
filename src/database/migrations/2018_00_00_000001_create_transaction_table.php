<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('larawallet.transaction_table',"lara_wallet_transactions"), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wallet_id')->index();
            $table->string('transaction_type')->index();
            $table->double("amount");
            $table->foreign('wallet_id') ->references('id')->on(config('larawallet.wallet_table',"lara_wallet_wallets"))->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('larawallet.transaction_table',"lara_wallet_transactions"));
    }
}