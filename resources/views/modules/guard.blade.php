<x-app-layout>
    <x-slot name="header">Guard Terminal</x-slot>
    <div class="grid gap-6 xl:grid-cols-[380px_1fr]">
        <form method="POST" action="{{ route('guard.store') }}" class="rounded-lg border border-white/10 bg-white/8 p-5">
            @csrf
            <h2 class="text-lg font-semibold text-white">Visitor Entry</h2>
            <div class="mt-4 grid gap-3">
                <input name="client_number" placeholder="Client number from QR" class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <input name="visitor_name" required placeholder="Visitor name" class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <input name="visitor_phone" placeholder="Phone" class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <input name="purpose" placeholder="Purpose" class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <button class="rounded-lg bg-[#CCD0CF] px-4 py-3 font-semibold text-[#06141B]">Log entry</button>
            </div>
        </form>
        <section class="rounded-lg border border-white/10 bg-[#11212D]/80 p-5">
            <h2 class="text-lg font-semibold text-white">Entry Monitoring</h2>
            @foreach ($logs as $log)
                <div class="mt-3 rounded-lg bg-white/5 p-4">
                    <div class="font-semibold text-white">{{ $log->visitor_name }}</div>
                    <div class="text-sm text-[#9BA8AB]">{{ $log->purpose }} - {{ $log->entered_at?->format('M d, Y h:i A') }}</div>
                </div>
            @endforeach
        </section>
    </div>
</x-app-layout>
