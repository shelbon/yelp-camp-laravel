<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('campgrounds')) {
            Schema::create('campgrounds', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('description');
                $table->longText('location');
                $table->float('price');
                $table->string('image');
                $table->foreignId('author_id')->constrained('users');
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campgrounds');
    }
};
