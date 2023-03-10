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
        Schema::table('customer_addresses', function (Blueprint $table) 
        {
            $table->string('province_id',20);
            $table->string('district_id',20);
            $table->string('ward_id',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn('province_id');
            $table->dropColumn('district_id');
            $table->dropColumn('ward_id');
        });
    }
};
