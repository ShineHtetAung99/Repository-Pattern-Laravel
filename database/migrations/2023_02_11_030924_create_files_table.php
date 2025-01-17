<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('original_name')->nullable();
            $table->string('file_name');
            $table->string('file_extension');
            $table->string('content_type');
            $table->string('file_directory')->nullable();
            $table->boolean('is_encrypted')->default(0);
            $table->string('main_module')->nullable();
            $table->string('sub_module')->nullable();
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
        Schema::dropIfExists('files');
    }
};
