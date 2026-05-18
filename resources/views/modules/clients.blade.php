<x-app-layout>
    <x-slot name="header">Client Management</x-slot>
    <div class="grid gap-6 xl:grid-cols-[380px_1fr]">
        <form method="POST" action="{{ route('clients.store') }}" class="rounded-lg border border-white/10 bg-white/8 p-5">
            @csrf
            <h2 class="text-lg font-semibold text-white">New Client</h2>
            <div class="mt-4 grid gap-3">
                @foreach (['first_name' => 'First name', 'middle_name' => 'Middle name', 'last_name' => 'Last name', 'email' => 'Email', 'phone' => 'Phone', 'address' => 'Address'] as $name => $label)
                    <label class="text-sm text-[#9BA8AB]">{{ $label }}
                        <input name="{{ $name }}" class="mt-1 w-full rounded-lg border-white/10 bg-[#06141B] text-white focus:border-[#9BA8AB] focus:ring-[#9BA8AB]" @if(in_array($name, ['first_name', 'last_name'])) required @endif>
                    </label>
                @endforeach
                <button class="rounded-lg bg-[#CCD0CF] px-4 py-3 font-semibold text-[#06141B] transition hover:bg-white">Create client</button>
            </div>
        </form>
        <section class="rounded-lg border border-white/10 bg-[#11212D]/80 p-5">
            <h2 class="text-lg font-semibold text-white">Client Records</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10 text-sm">
                    <tbody class="divide-y divide-white/10">
                        @foreach ($clients as $client)
                            <tr>
                                <td class="px-3 py-3 text-white">{{ $client->client_number }}</td>
                                <td class="px-3 py-3">{{ $client->full_name }}</td>
                                <td class="px-3 py-3">{{ $client->phone }}</td>
                                <td class="px-3 py-3 text-right"><a class="text-[#CCD0CF] underline" href="{{ route('clients.id', $client) }}">QR ID</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $clients->links() }}</div>
        </section>
    </div>
</x-app-layout>
