<x-app-layout>
    <x-slot name="header">Billing Management</x-slot>
    <div class="grid gap-6 xl:grid-cols-[380px_1fr]">
        <form method="POST" action="{{ route('billing.store') }}" class="rounded-lg border border-white/10 bg-white/8 p-5">
            @csrf
            <h2 class="text-lg font-semibold text-white">Generate Billing</h2>
            <div class="mt-4 grid gap-3">
                <select name="client_id" required class="rounded-lg border-white/10 bg-[#06141B] text-white">
                    <option value="">Select client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->client_number }} - {{ $client->full_name }}</option>
                    @endforeach
                </select>
                <input name="type" value="lot" class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <input name="amount" type="number" step="0.01" min="1" placeholder="Amount" required class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <input name="due_date" type="date" class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <textarea name="description" placeholder="Description" class="rounded-lg border-white/10 bg-[#06141B] text-white"></textarea>
                <button class="rounded-lg bg-[#CCD0CF] px-4 py-3 font-semibold text-[#06141B]">Save billing</button>
            </div>
        </form>
        <section class="rounded-lg border border-white/10 bg-[#11212D]/80 p-5">
            <h2 class="text-lg font-semibold text-white">Open Accounts</h2>
            @foreach ($billings as $billing)
                <div class="mt-3 rounded-lg bg-white/5 p-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div><div class="font-semibold text-white">{{ $billing->billing_number }}</div><div class="text-sm text-[#9BA8AB]">{{ $billing->client?->full_name }}</div></div>
                        <div class="text-right"><div>PHP {{ number_format($billing->balance, 2) }}</div><div class="text-xs uppercase text-[#9BA8AB]">{{ $billing->status }}</div></div>
                    </div>
                </div>
            @endforeach
            <div class="mt-4">{{ $billings->links() }}</div>
        </section>
    </div>
</x-app-layout>
