<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_lead');
            $table->boolean('converted');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations !
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounts');
    }
}
