<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelTrackingUpdateTable extends Migration
{
    public function up()
    {
        Schema::create('parcel_tracking_update', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parcel_id');
            $table->unsignedBigInteger('tracking_update_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            // Foreign key constraints
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
            $table->foreign('tracking_update_id')->references('id')->on('tracking_updates')->onDelete('cascade');

            // Ensure uniqueness
            $table->unique(['parcel_id', 'tracking_update_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('parcel_tracking_update');
    }
}
