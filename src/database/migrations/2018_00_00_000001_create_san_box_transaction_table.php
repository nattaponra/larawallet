<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSanBoxTransactionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('larawallet.sanbox_transaction_table',"lara_wallet_sanbox_transactions"), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wallet_id')->index();
            $table->string('transaction_type')->index();
            $table->double("amount");
            $table->foreign('wallet_id') ->references('id')->on(config('larawallet.sanbox_wallet_table',"lara_wallet_sanbox_wallets"))->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('larawallet.sanbox_transaction_table',"lara_wallet_sanbox_transactions"));
    }
}