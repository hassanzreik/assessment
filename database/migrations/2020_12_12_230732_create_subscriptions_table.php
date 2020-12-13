<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
	        $table->unsignedBigInteger('user_id');
	        $table->unsignedBigInteger('product_id');
	        $table->unsignedBigInteger('operator_id');
	        $table->unsignedBigInteger('country_id')->nullable();
	        $table->string('mobile_number')->nullable();
	        $table->enum('status', ['pending','subscribed','cancelled','invalid'])->nullable();
	        $table->date('expiry_date');
            $table->timestamps();
            $table->softDeletes();
	        $table->foreign('user_id', 'fk_subscriptions_users_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
	        $table->foreign('product_id', 'fk_subscriptions_products_product_id')->references('id')->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
	        $table->foreign('operator_id', 'fk_subscriptions_operators_operator_id')->references('id')->on('operators')->onUpdate('NO ACTION')->onDelete('NO ACTION');
	        $table->foreign('country_id', 'fk_subscriptions_countries_country_id')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
