<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $booking->booking_code }} | Sanda</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Lora"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
        }
    </style>
</head>
<body class="bg-slate-100 p-4 sm:p-8 font-sans antialiased text-slate-800">

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-8 sm:p-12">
        <!-- Print Toolbar -->
        <div class="no-print flex justify-between items-center mb-8 pb-4 border-b border-slate-200">
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs font-bold text-slate-600 hover:underline">&larr; Back to Booking</a>
            <button onclick="window.print()" class="bg-slate-900 text-white font-bold text-xs px-4 py-2 rounded-lg shadow">
                Print Official Invoice
            </button>
        </div>

        <!-- Official Letterhead -->
        <div class="flex items-start justify-between border-b-2 border-emerald-800 pb-6 mb-8">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Sanda" class="h-20 w-auto rounded border border-slate-200">
                <div>
                    <h1 class="font-serif font-bold text-2xl text-slate-900">Sanda</h1>
                    <div class="text-xs text-slate-600">Sella Katharagama, Monaragala, Sri Lanka</div>
                    <div class="text-xs text-slate-500">Hotline: +94 77 987 6543 | Email: info@sandaresort.com</div>
                </div>
            </div>

            <div class="text-right">
                <div class="text-xl font-bold font-serif text-slate-900 uppercase tracking-wider">Guest Invoice</div>
                <div class="font-mono text-sm font-bold text-emerald-800 mt-1">{{ $booking->booking_code }}</div>
                <div class="text-xs text-slate-500 mt-1">Date: {{ date('M d, Y') }}</div>
            </div>
        </div>

        <!-- Guest and Stay Info -->
        <div class="grid grid-cols-2 gap-8 mb-8 text-sm">
            <div>
                <span class="text-xs uppercase font-bold text-slate-400 block mb-1">Billed To (Guest)</span>
                <strong class="text-slate-900 text-base block">{{ $booking->guest_name }}</strong>
                <div class="text-slate-600">{{ $booking->guest_phone }}</div>
                <div class="text-slate-600">{{ $booking->guest_email }}</div>
                @if($booking->guest_nic_passport)
                    <div class="text-xs text-slate-500">NIC/Passport: {{ $booking->guest_nic_passport }}</div>
                @endif
            </div>

            <div class="text-right">
                <span class="text-xs uppercase font-bold text-slate-400 block mb-1">Reservation Schedule</span>
                <div>Check-in: <strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</strong> (2:00 PM)</div>
                <div>Check-out: <strong>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</strong> (11:00 AM)</div>
                <div>Stay: <strong>{{ $booking->nights }} Night(s)</strong> ({{ $booking->adults }} Adults, {{ $booking->children }} Children)</div>
                @if($booking->room)
                    <div class="font-bold text-emerald-800 mt-1">Assigned Unit: Room {{ $booking->room->room_number }}</div>
                @endif
            </div>
        </div>

        <!-- Line Items Table -->
        <table class="w-full text-left text-sm mb-8 border border-slate-200">
            <thead class="bg-slate-50 text-xs font-bold text-slate-600 uppercase border-b border-slate-200">
                <tr>
                    <th class="py-3 px-4">Description</th>
                    <th class="py-3 px-4 text-center">Qty / Nights</th>
                    <th class="py-3 px-4 text-right">Unit Rate (Rs.)</th>
                    <th class="py-3 px-4 text-right">Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr>
                    <td class="py-3 px-4">
                        <strong class="text-slate-900">{{ $booking->roomType->name }}</strong>
                        <div class="text-xs text-slate-500">{{ $booking->roomType->bed_type }}</div>
                    </td>
                    <td class="py-3 px-4 text-center">{{ $booking->nights }}</td>
                    <td class="py-3 px-4 text-right">{{ number_format($booking->room_rate) }}</td>
                    <td class="py-3 px-4 text-right font-medium">{{ number_format($booking->room_subtotal) }}</td>
                </tr>

                @foreach($booking->addons as $addon)
                    <tr>
                        <td class="py-3 px-4">
                            <span class="text-slate-800">{{ $addon->name }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">{{ $addon->pivot->quantity }}</td>
                        <td class="py-3 px-4 text-right">{{ number_format($addon->pivot->unit_price) }}</td>
                        <td class="py-3 px-4 text-right font-medium">{{ number_format($addon->pivot->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="flex justify-end mb-8">
            <div class="w-72 space-y-2 text-sm">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <span>Rs. {{ number_format($booking->total_amount) }}</span>
                </div>
                <div class="flex justify-between font-bold text-emerald-800">
                    <span>Advance Deposit Paid:</span>
                    <span>Rs. {{ number_format($booking->advance_paid) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg text-slate-900 pt-2 border-t-2 border-slate-800">
                    <span>Balance Due:</span>
                    <span>Rs. {{ number_format($booking->balance_due) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Signatures -->
        <div class="pt-12 border-t border-slate-200 grid grid-cols-2 text-xs text-slate-500 gap-8 mt-12">
            <div>
                <div class="border-b border-slate-300 w-48 mb-2"></div>
                <span>Guest Signature</span>
            </div>
            <div class="text-right">
                <div class="border-b border-slate-300 w-48 ml-auto mb-2"></div>
                <span>Authorized Resort Representative</span>
            </div>
        </div>

        <div class="text-center text-[10px] text-slate-400 mt-8">
            Thank you for staying at Sanda • May your journey be blessed!
        </div>
    </div>

</body>
</html>
