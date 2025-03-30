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
            $table->boolean('cancellation_requested')->default(false);
            $table->text('cancellation_reason')->nullable();
            $table->string('cancellation_status')->nullable()->comment('pending, approved, rejected');
            $table->text('rejection_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'cancellation_requested',
                'cancellation_reason',
                'cancellation_status',
                'rejection_reason'
            ]);
        });
    }
};