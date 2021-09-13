<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->date('birth_date');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('github_url');
            $table->string('linkedin_url');
            $table->string('facebook_url');
            $table->string('instagram_url');
            $table->foreignId('district_id')->constrained();
            $table->foreignId('user_type_id')->constrained();
            $table->foreignId('school_class_id')->constrained();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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