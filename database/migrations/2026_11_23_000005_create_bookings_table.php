<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('room_type_id')->constrained('room_types')->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');
            $table->string('guest_nic_passport')->nullable();
            $table->text('guest_address')->nullable();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('nights')->default(1);
            $table->integer('adults')->default(2);
            $table->integer('children')->default(0);
            $table->decimal('room_rate', 10, 2);
            $table->decimal('room_subtotal', 10, 2);
            $table->decimal('addons_total', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('advance_paid', 10, 2)->default(0);
            $table->decimal('balance_due', 10, 2)->default(0);
            $table->string('payment_status')->default('pending'); // pending, advance_paid, paid_in_full, refunded
            $table->string('payment_method')->default('cash'); // cash, bank_transfer, card_at_desk, online
            $table->string('booking_status')->default('pending'); // pending, confirmed, checked_in, checked_out, cancelled
            $table->text('special_requests')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('addon_id')->constrained('addons')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_addons');
        Schema::dropIfExists('bookings');
    }
};
