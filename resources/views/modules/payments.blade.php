<x-app-layout>
    <x-slot name="header">Cashier Payments</x-slot>
    <div class="grid gap-6 xl:grid-cols-[380px_1fr]">
        <form method="POST" action="{{ route('payments.store') }}" class="rounded-lg border border-white/10 bg-white/8 p-5">
            @csrf
            <h2 class="text-lg font-semibold text-white">Accept Cash Payment</h2>
            <div class="mt-4 grid gap-3">
                <select name="billing_id" required class="rounded-lg border-white/10 bg-[#06141B] text-white">
                    <option value="">Select billing</option>
                    @foreach ($billings as $billing)
                        <option value="{{ $billing->id }}">{{ $billing->billing_number }} - {{ $billing->client?->full_name }} - PHP {{ number_format($billing->balance, 2) }}</option>
                    @endforeach
                </select>
                <input name="amount" type="number" step="0.01" min="1" required placeholder="Amount paid" class="rounded-lg border-white/10 bg-[#06141B] text-white">
                <textarea name="notes" placeholder="Notes" class="rounded-lg border-white/10 bg-[#06141B] text-white"></textarea>
                <button class="rounded-lg bg-[#CCD0CF] px-4 py-3 font-semibold text-[#06141B]">Post payment</button>
            </div>
        </form>
        <section class="rounded-lg border border-white/10 bg-[#11212D]/80 p-5">
            <h2 class="text-lg font-semibold text-white">Payment History</h2>
            @foreach ($payments as $payment)
                <div class="mt-3 rounded-lg bg-white/5 p-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div><div class="font-semibold text-white">{{ $payment->reference_number }}</div><div class="text-sm text-[#9BA8AB]">{{ $payment->client?->full_name }} by {{ $payment->collector?->name }}</div></div>
                        <div class="text-right"><div>PHP {{ number_format($payment->amount, 2) }}</div><a class="text-xs text-[#CCD0CF] underline" href="{{ route('payments.receipt', $payment) }}">Receipt PDF</a></div>
                    </div>
                </div>
            @endforeach
            <div class="mt-4">{{ $payments->links() }}</div>
        </section>
    </div>
</x-app-layout>
