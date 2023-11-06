<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->longText('description');
            $table->string('position_type');
            $table->integer('salary_min');
            $table->integer('salary_max');
            $table->string('location')->nullable();
            $table->foreignUuid('company_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
