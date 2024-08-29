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
        Schema::table('tracking_updates', function (Blueprint $table) {
            $table->string('tracking_number')->nullable(); // Add this line
        });
    }
    
    public function down()
    {
        Schema::table('tracking_updates', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
    }
    
};
