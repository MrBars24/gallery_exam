<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->string('username', 100);
			$table->string('email', 100);
			$table->string('street', 100);
			$table->string('suite', 100);
			$table->string('city', 100);
			$table->string('zipcode', 100);
            $table->decimal('geo_lat', 9, 6);
            $table->decimal('geo_lng', 9, 6);
			$table->string('phone', 100);
			$table->string('website', 255);
			$table->string('company_name', 100);
			$table->string('company_catch_phrase', 100);
			$table->string('company_bs', 100);
            $table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
