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
        Schema::create('parcel_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parcel_id'); 
            $table->string('previous_status');
            $table->string('new_status');
            $table->string('location');
            $table->text('description')->nullable();

            // Foreign key constraint
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
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
        Schema::dropIfExists('parcel_histories');
    }
};
