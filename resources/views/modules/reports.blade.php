<x-app-layout>
    <x-slot name="header">Reports and Analytics</x-slot>
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-lg border border-white/10 bg-white/8 p-5"><div class="text-sm text-[#9BA8AB]">Daily collections</div><div class="mt-3 text-3xl font-semibold text-white">PHP {{ number_format($dailyCollections, 2) }}</div></div>
        <div class="rounded-lg border border-white/10 bg-white/8 p-5"><div class="text-sm text-[#9BA8AB]">Monthly income</div><div class="mt-3 text-3xl font-semibold text-white">PHP {{ number_format($monthlyIncome, 2) }}</div></div>
        <a href="{{ route('reports.collections.pdf') }}" class="rounded-lg border border-white/10 bg-[#CCD0CF] p-5 text-[#06141B] transition hover:bg-white"><div class="text-sm">Export</div><div class="mt-3 text-2xl font-semibold">Collections PDF</div></a>
    </div>
    <section class="mt-6 rounded-lg border border-white/10 bg-[#11212D]/80 p-5">
        <h2 class="text-lg font-semibold text-white">Lot Occupancy</h2>
        <div class="mt-4 grid gap-3 sm:grid-cols-4">
            @foreach ($occupancy as $status => $total)
                <div class="rounded-lg bg-white/5 p-4"><div class="text-sm uppercase text-[#9BA8AB]">{{ $status }}</div><div class="mt-2 text-2xl text-white">{{ $total }}</div></div>
            @endforeach
        </div>
    </section>
</x-app-layout>
