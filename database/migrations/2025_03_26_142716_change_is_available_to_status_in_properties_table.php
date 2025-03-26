<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Add this import

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('property_type'); // Add new column
        });

        // Convert existing boolean values to the new status values
        DB::statement("UPDATE properties SET status = CASE 
            WHEN is_available = 1 THEN 'available' 
            ELSE 'pending' 
            END");

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('is_available'); // Remove old column
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('property_type'); // Add old column back
        });

        // Convert status values back to boolean
        DB::statement("UPDATE properties SET is_available = CASE 
            WHEN status = 'available' THEN 1 
            ELSE 0 
            END");

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('status'); // Remove new column
        });
    }
};