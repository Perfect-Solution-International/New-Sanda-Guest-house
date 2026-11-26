<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_vip')->default(false)->after('country');
            $table->boolean('is_blacklisted')->default(false)->after('is_vip');
            $table->text('blacklist_reason')->nullable()->after('is_blacklisted');
            $table->text('special_preferences')->nullable()->after('blacklist_reason');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['is_vip', 'is_blacklisted', 'blacklist_reason', 'special_preferences']);
        });
    }
};
