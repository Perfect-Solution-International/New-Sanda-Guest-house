<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('check_in_time')->default('14:00')->after('check_in_date');
            $table->string('check_out_time')->default('11:00')->after('check_out_date');
            $table->dateTime('check_in_at')->nullable()->after('check_out_time')->index();
            $table->dateTime('check_out_at')->nullable()->after('check_in_at')->index();
            $table->decimal('duration_hours', 8, 2)->nullable()->after('nights');
            $table->string('duration_type')->default('nights')->after('duration_hours'); // 'nights', 'hours'
        });

        // Backfill any existing records
        $bookings = DB::table('bookings')->get();
        foreach ($bookings as $b) {
            $inTime = $b->check_in_time ?: '14:00';
            $outTime = $b->check_out_time ?: '11:00';
            $inAt = date('Y-m-d H:i:s', strtotime("{$b->check_in_date} {$inTime}"));
            $outAt = date('Y-m-d H:i:s', strtotime("{$b->check_out_date} {$outTime}"));
            $diffHours = max(1, (strtotime($outAt) - strtotime($inAt)) / 3600);

            DB::table('bookings')->where('id', $b->id)->update([
                'check_in_time' => $inTime,
                'check_out_time' => $outTime,
                'check_in_at' => $inAt,
                'check_out_at' => $outAt,
                'duration_hours' => $diffHours,
                'duration_type' => ($b->nights ?? 1) >= 1 ? 'nights' : 'hours',
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['check_in_at']);
            $table->dropIndex(['check_out_at']);
            $table->dropColumn([
                'check_in_time',
                'check_out_time',
                'check_in_at',
                'check_out_at',
                'duration_hours',
                'duration_type',
            ]);
        });
    }
};
