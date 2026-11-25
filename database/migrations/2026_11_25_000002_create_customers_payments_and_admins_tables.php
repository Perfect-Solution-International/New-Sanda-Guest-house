<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Customers Table
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone')->index();
                $table->string('email')->nullable()->index();
                $table->string('nic_passport')->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->default('Sri Lanka');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Add customer_id to bookings table if not present
        if (Schema::hasTable('bookings') && !Schema::hasColumn('bookings', 'customer_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->foreignId('customer_id')->nullable()->after('id')->constrained('customers')->nullOnDelete();
            });
        }

        // 2. Payments Table
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
                $table->string('payment_reference')->unique();
                $table->decimal('amount', 10, 2);
                $table->string('payment_type')->default('advance'); // advance, balance, full, refund
                $table->string('payment_method')->default('cash'); // cash, bank_transfer, card, online
                $table->string('payment_status')->default('completed'); // pending, completed, failed, refunded
                $table->timestamp('paid_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 3. Admins Table
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->string('role')->default('admin'); // admin, receptionist, manager
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Backfill data:
        // Copy users into admins
        if (Schema::hasTable('users') && Schema::hasTable('admins')) {
            $users = DB::table('users')->get();
            foreach ($users as $user) {
                DB::table('admins')->updateOrInsert(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'phone' => $user->phone ?? null,
                        'role' => $user->role ?? 'admin',
                        'password' => $user->password,
                        'created_at' => $user->created_at ?? now(),
                        'updated_at' => $user->updated_at ?? now(),
                    ]
                );
            }
        }

        // Backfill customers from existing bookings
        if (Schema::hasTable('bookings') && Schema::hasTable('customers')) {
            $bookings = DB::table('bookings')->get();
            foreach ($bookings as $b) {
                if ($b->guest_name && $b->guest_phone) {
                    $customer = DB::table('customers')->where('phone', $b->guest_phone)->first();
                    if (!$customer) {
                        $customerId = DB::table('customers')->insertGetId([
                            'name' => $b->guest_name,
                            'phone' => $b->guest_phone,
                            'email' => $b->guest_email,
                            'nic_passport' => $b->guest_nic_passport,
                            'address' => $b->guest_address,
                            'created_at' => $b->created_at ?? now(),
                            'updated_at' => $b->updated_at ?? now(),
                        ]);
                    } else {
                        $customerId = $customer->id;
                    }

                    DB::table('bookings')->where('id', $b->id)->update(['customer_id' => $customerId]);

                    // Backfill advance payment
                    if ($b->advance_paid > 0) {
                        DB::table('payments')->updateOrInsert(
                            ['payment_reference' => 'PAY-ADV-' . $b->booking_code],
                            [
                                'booking_id' => $b->id,
                                'amount' => $b->advance_paid,
                                'payment_type' => 'advance',
                                'payment_method' => $b->payment_method ?? 'cash',
                                'payment_status' => 'completed',
                                'paid_at' => $b->created_at ?? now(),
                                'notes' => 'Advance payment collected',
                                'created_at' => $b->created_at ?? now(),
                                'updated_at' => $b->updated_at ?? now(),
                            ]
                        );
                    }

                    // Backfill full/balance payment if settled
                    if ($b->payment_status === 'full_paid' && $b->balance_due <= 0 && $b->total_amount > $b->advance_paid) {
                        $balanceAmount = $b->total_amount - $b->advance_paid;
                        DB::table('payments')->updateOrInsert(
                            ['payment_reference' => 'PAY-BAL-' . $b->booking_code],
                            [
                                'booking_id' => $b->id,
                                'amount' => $balanceAmount,
                                'payment_type' => 'balance',
                                'payment_method' => $b->payment_method ?? 'cash',
                                'payment_status' => 'completed',
                                'paid_at' => $b->updated_at ?? now(),
                                'notes' => 'Settled balance payment',
                                'created_at' => $b->updated_at ?? now(),
                                'updated_at' => $b->updated_at ?? now(),
                            ]
                        );
                    }
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'customer_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
                $table->dropColumn('customer_id');
            });
        }
        Schema::dropIfExists('payments');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('admins');
    }
};
