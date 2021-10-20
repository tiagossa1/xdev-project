<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('post_id')->nullable();
            $table->unsignedBigInteger('moderator_id')->nullable();
            $table->foreign('moderator_id')->nullable()->constrained()->references('id')->on('users');
            $table->foreignId('report_conclusion_id')->nullable()->constrained();
            $table->foreignId('comment_id')->nullable();
            $table->boolean('closed')->default(0)->nullable();
            $table->string('reason');
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
        Schema::dropIfExists('reports');
    }
}
