<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            'Clients' => number_format($stats['clients']),
            'Vacant Lots' => number_format($stats['vacant_lots']),
            'Occupied Lots' => number_format($stats['occupied_lots']),
            'Today Collections' => 'PHP '.number_format($stats['today_collections'], 2),
            'Open Balance' => 'PHP '.number_format($stats['pending_billings'], 2),
            'Pending Reservations' => number_format($stats['pending_reservations']),
        ] as $label => $value)
            <div class="rounded-lg border border-white/10 bg-white/8 p-5 shadow-2xl shadow-black/20 backdrop-blur">
                <div class="text-sm text-[#9BA8AB]">{{ $label }}</div>
                <div class="mt-3 text-3xl font-semibold text-white">{{ $value }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <section class="rounded-lg border border-white/10 bg-[#11212D]/80 p-5 xl:col-span-2">
            <h2 class="text-lg font-semibold text-white">Recent Payments</h2>
            <div class="mt-4 overflow-hidden rounded-lg border border-white/10">
                <table class="min-w-full divide-y divide-white/10 text-sm">
                    <tbody class="divide-y divide-white/10">
                        @forelse ($recentPayments as $payment)
                            <tr class="bg-white/[0.03]">
                                <td class="px-4 py-3 text-white">{{ $payment->reference_number }}</td>
                                <td class="px-4 py-3">{{ $payment->client?->full_name }}</td>
                                <td class="px-4 py-3 text-right">PHP {{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td class="px-4 py-6 text-[#9BA8AB]">No payments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        <section class="rounded-lg border border-white/10 bg-[#11212D]/80 p-5">
            <h2 class="text-lg font-semibold text-white">Lot Watch</h2>
            <div class="mt-4 space-y-3">
                @foreach ($lots as $lot)
                    <div class="rounded-lg bg-white/5 p-3">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-white">{{ $lot->section?->code }}-{{ $lot->lot_number }}</span>
                            <span class="rounded-full px-2 py-1 text-xs bg-[#253745]">{{ ucfirst($lot->status) }}</span>
                        </div>
                        <div class="mt-1 text-sm text-[#9BA8AB]">{{ $lot->client?->full_name ?? 'No owner assigned' }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
