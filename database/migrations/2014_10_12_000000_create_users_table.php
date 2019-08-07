<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('business_name')->nullable()->comment = "only for company";
            $table->unique('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('status')->comment = "0 = company, 1 = applicant";
            $table->string('picture')->nullable()->comment = "only for applicant";
            $table->string('resume')->nullable()->comment = "only for applicant";
            $table->string('skill')->nullable()->comment = "only for applicant";
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
