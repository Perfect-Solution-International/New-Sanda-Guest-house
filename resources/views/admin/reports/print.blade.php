<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Management Report - Sanda Guest House</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; color: black !important; }
            .print-page { box-shadow: none !important; border: none !important; max-width: 100% !important; margin: 0 !important; padding: 1.5cm !important; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans p-4 sm:p-8 antialiased">

    <!-- Floating Top Toolbar (Hidden on print) -->
    <div class="no-print max-w-5xl mx-auto mb-6 bg-slate-900 text-white p-4 rounded-2xl shadow-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.index', request()->query()) }}" class="text-xs text-slate-300 hover:text-white flex items-center gap-1 font-semibold">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
            <span class="text-slate-600">|</span>
            <span class="text-xs font-serif font-bold text-white">Official Management Executive Summary</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-5 py-2 rounded-xl text-xs flex items-center gap-2 shadow-md transition cursor-pointer">
                <i class="fa-solid fa-print"></i> Print / Save as PDF
            </button>
        </div>
    </div>

    <!-- Official Report Document Container -->
    <div class="print-page max-w-5xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-lg border border-slate-200 space-y-8">

        <!-- Header Letterhead -->
        <div class="flex items-start justify-between border-b-2 border-slate-900 pb-6 gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Sanda" class="h-12 w-auto object-contain">
                    <div>
                        <h1 class="font-serif font-bold text-2xl text-slate-900 leading-tight">Sanda Guest House</h1>
                        <p class="text-xs text-amber-700 font-bold tracking-widest uppercase">Executive Performance & Occupancy Report</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500 pt-2 leading-relaxed">
                    Near Sella Temple Road, Kataragama, Sri Lanka<br>
                    Hotline: +94 77 987 6543 / 077 444 5566 &bull; Email: info@sandaguesthouse.lk
                </p>
            </div>

            <div class="text-right text-xs space-y-1">
                <span class="inline-block bg-slate-100 text-slate-800 font-mono font-bold px-3 py-1 rounded-lg">
                    REPORT #SGH-{{ $startDate->format('Ymd') }}-{{ $endDate->format('Ymd') }}
                </span>
                <div class="text-slate-500 pt-1">
                    Generated: <strong class="text-slate-800">{{ now()->format('M d, Y h:i A') }}</strong>
                </div>
                <div class="text-slate-500">
                    Period: <strong class="text-slate-900">{{ $startDate->format('M d, Y') }}</strong> to <strong class="text-slate-900">{{ $endDate->format('M d, Y') }}</strong>
                </div>
                <div class="text-[11px] font-semibold text-emerald-700">
                    Duration: {{ $daysCount }} Calendar Days
                </div>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 text-center">
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] uppercase font-bold text-slate-500 block">Gross Revenue</span>
                <strong class="text-base font-serif font-bold text-slate-900 block mt-1">Rs. {{ number_format($grossRevenue) }}</strong>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] uppercase font-bold text-emerald-600 block">Advance Collected</span>
                <strong class="text-base font-serif font-bold text-emerald-700 block mt-1">Rs. {{ number_format($advanceCollected) }}</strong>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] uppercase font-bold text-rose-600 block">Balance Due</span>
                <strong class="text-base font-serif font-bold text-rose-700 block mt-1">Rs. {{ number_format($balanceDue) }}</strong>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] uppercase font-bold text-blue-600 block">Occupancy Rate</span>
                <strong class="text-base font-serif font-bold text-blue-800 block mt-1">{{ $occupancyRate }}%</strong>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] uppercase font-bold text-purple-600 block">ADR (Daily Rate)</span>
                <strong class="text-base font-serif font-bold text-purple-800 block mt-1">Rs. {{ number_format($adr) }}</strong>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-[10px] uppercase font-bold text-slate-500 block">Total Stays</span>
                <strong class="text-base font-serif font-bold text-slate-900 block mt-1">{{ $totalBookings }}</strong>
            </div>
        </div>

        <!-- Room-Wise Occupancy & Income Table -->
        <div class="space-y-3">
            <h3 class="font-serif font-bold text-slate-900 text-sm border-b border-slate-200 pb-1 flex items-center justify-between">
                <span>Room-Wise Performance Breakdown</span>
                <span class="text-xs text-slate-500 font-sans font-normal">{{ count($roomBreakdown) }} Physical Rooms Audited</span>
            </h3>

            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 uppercase tracking-wider text-[10px] font-bold border-y border-slate-300">
                        <th class="py-2.5 px-3">Room</th>
                        <th class="py-2.5 px-3">Category</th>
                        <th class="py-2.5 px-3">Floor / Wing</th>
                        <th class="py-2.5 px-3 text-center">Stays</th>
                        <th class="py-2.5 px-3 text-center">Nights</th>
                        <th class="py-2.5 px-3 text-center">Occupancy %</th>
                        <th class="py-2.5 px-3 text-right">Revenue (Rs)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($roomBreakdown as $rb)
                        <tr>
                            <td class="py-2 px-3 font-bold font-mono">{{ str_starts_with($rb['room']->room_number, 'Room') ? $rb['room']->room_number : 'Room ' . $rb['room']->room_number }}</td>
                            <td class="py-2 px-3 text-slate-700">{{ $rb['room']->roomType?->name ?? 'Standard' }}</td>
                            <td class="py-2 px-3 text-slate-500">{{ $rb['room']->floor_wing }}</td>
                            <td class="py-2 px-3 text-center font-mono">{{ $rb['bookings_count'] }}</td>
                            <td class="py-2 px-3 text-center font-mono">{{ $rb['nights'] }}</td>
                            <td class="py-2 px-3 text-center font-mono font-bold">{{ $rb['occupancy_rate'] }}%</td>
                            <td class="py-2 px-3 text-right font-mono font-bold text-slate-900">
                                Rs. {{ number_format($rb['revenue']) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-slate-50 font-bold border-t-2 border-slate-400">
                        <td colspan="3" class="py-2.5 px-3 uppercase text-[10px]">Total Room Performance:</td>
                        <td class="py-2.5 px-3 text-center font-mono">{{ $confirmedBookings }}</td>
                        <td class="py-2.5 px-3 text-center font-mono">{{ $occupiedNights }}</td>
                        <td class="py-2.5 px-3 text-center font-mono">{{ $occupancyRate }}%</td>
                        <td class="py-2.5 px-3 text-right font-mono text-slate-900">Rs. {{ number_format($grossRevenue) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Financial Summary Breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                <strong class="font-serif font-bold text-slate-900 block border-b border-slate-200 pb-1">Revenue Stream Analysis</strong>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-600">Room Rental Charges:</span>
                    <strong class="font-mono text-slate-900">Rs. {{ number_format($roomRevenue) }}</strong>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-600">Safari & Tour Addons:</span>
                    <strong class="font-mono text-slate-900">Rs. {{ number_format($addonsRevenue) }}</strong>
                </div>
                <div class="flex justify-between py-1.5 font-bold text-sm text-slate-900">
                    <span>Total Gross Invoiced:</span>
                    <span class="font-mono text-brand-900">Rs. {{ number_format($grossRevenue) }}</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                <strong class="font-serif font-bold text-slate-900 block border-b border-slate-200 pb-1">Payment Settlement Status</strong>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-600">Advance Collected (Cash/Bank):</span>
                    <strong class="font-mono text-emerald-700">Rs. {{ number_format($advanceCollected) }}</strong>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-600">Balance Outstanding:</span>
                    <strong class="font-mono text-rose-600">Rs. {{ number_format($balanceDue) }}</strong>
                </div>
                <div class="flex justify-between py-1.5 font-bold text-xs text-slate-700">
                    <span>Collection Efficiency:</span>
                    <span class="font-mono">{{ $grossRevenue > 0 ? round(($advanceCollected / $grossRevenue) * 100) : 0 }}% advance ratio</span>
                </div>
            </div>
        </div>

        <!-- Sign-off & Verification -->
        <div class="pt-8 border-t border-slate-300 grid grid-cols-2 gap-8 text-xs">
            <div>
                <span class="text-slate-400 block mb-12">Prepared By (Front Desk / Accountant):</span>
                <div class="border-t border-slate-400 pt-1 font-semibold text-slate-800">
                    Front Desk Supervisor / Duty Manager
                </div>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block mb-12">Certified & Approved By:</span>
                <div class="border-t border-slate-400 pt-1 font-serif font-bold text-slate-900">
                    General Manager, Sanda Guest House
                </div>
            </div>
        </div>

    </div>

</body>
</html>
