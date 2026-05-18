<x-app-layout>
    <x-slot name="header">Mobile Collector</x-slot>
    <div class="mx-auto max-w-md pb-24">
        <div class="rounded-lg border border-white/10 bg-[#11212D] p-5 shadow-2xl">
            <div class="flex items-center justify-between">
                <div><div class="text-sm text-[#9BA8AB]">Today</div><div class="text-3xl font-bold text-white">PHP {{ number_format($stats['today'], 2) }}</div></div>
                <div class="rounded-lg bg-white/10 px-4 py-3 text-center"><div class="text-2xl text-white">{{ $stats['assigned'] }}</div><div class="text-xs text-[#9BA8AB]">Assigned</div></div>
            </div>
            <button class="mt-6 w-full rounded-lg bg-[#CCD0CF] px-5 py-4 text-lg font-bold text-[#06141B]" x-data @click="$dispatch('open-scanner')">Scan Client QR</button>
            <div class="mt-6 rounded-lg bg-[#06141B] p-4">
                <div class="text-sm font-semibold text-white">Offline Queue</div>
                <div class="mt-2 text-sm text-[#9BA8AB]">Transactions are stored locally and pushed to the API when the device reconnects.</div>
            </div>
        </div>
        <div class="mt-6 space-y-3">
            @foreach ($recentPayments as $payment)
                <div class="rounded-lg border border-white/10 bg-white/8 p-4">
                    <div class="flex justify-between gap-3"><span class="font-semibold text-white">{{ $payment->client?->full_name }}</span><span>PHP {{ number_format($payment->amount, 2) }}</span></div>
                    <div class="mt-1 text-xs text-[#9BA8AB]">{{ $payment->reference_number }}</div>
                </div>
            @endforeach
        </div>
        <nav class="fixed inset-x-0 bottom-0 z-40 border-t border-white/10 bg-[#06141B]/95 px-5 py-3 backdrop-blur lg:hidden">
            <div class="mx-auto flex max-w-md justify-around text-xs text-[#CCD0CF]">
                <a href="{{ route('collector.app') }}">Dashboard</a>
                <span>Scanner</span>
                <span>Sync</span>
                <span>Receipts</span>
            </div>
        </nav>
    </div>
</x-app-layout>
