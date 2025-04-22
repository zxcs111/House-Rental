<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('hidden_by_tenant')->default(false)->after('hidden');
            $table->boolean('hidden_by_landlord')->default(false)->after('hidden_by_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['hidden_by_tenant', 'hidden_by_landlord']);
        });
    }
};