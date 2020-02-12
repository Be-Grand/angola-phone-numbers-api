<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->string('email')->unique();
            $table->string('nif')->nullable()->unique();
            $table->string('bi')->nullable()->unique();
            $table->string('residence_card')->nullable()->unique();
            $table->string('passport')->nullable()->unique();
            $table->enum('gender', [2, 1, 0]);
            $table->string('address')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
