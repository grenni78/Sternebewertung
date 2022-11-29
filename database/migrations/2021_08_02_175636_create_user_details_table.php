<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('street');
            $table->string('street_number');
            $table->string('zip', 10);
            $table->string('city');
            $table->boolean('is_commercial')->default(false);
            $table->string('company')->nullable();
            $table->string('industry')->nullable();
            $table->string('homepage')->nullable();
            $table->string('tax_id')->nullable();
            $table->text('company_about')->nullable();
            $table->string('searchwords')->nullable();
            $table->string('tel')->nullable();
            $table->string('gmaps_user')->nullable();
            $table->string('gmaps_url')->nullable();
            $table->string('paypal_user')->nullable();
        });

        Schema::table('user_details', function ($table) {
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
