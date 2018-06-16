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
        Schema::create(config('PAYMENT.DATABASE.TABLE',"wallet_system_transaction"), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('transaction_type_id')->index();
            $table->double("amount");
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('PAYMENT.DATABASE.TABLE',"wallet_system_transaction"));
    }
}