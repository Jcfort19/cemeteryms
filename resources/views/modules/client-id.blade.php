<x-app-layout>
    <x-slot name="header">Printable Client QR ID</x-slot>
    <div class="mx-auto max-w-md rounded-lg border border-white/10 bg-[#CCD0CF] p-6 text-[#06141B] shadow-2xl">
        <div class="text-sm font-semibold uppercase">CemeteryMS Client ID</div>
        <div class="mt-4 text-2xl font-bold">{{ $client->full_name }}</div>
        <div class="text-sm">{{ $client->client_number }}</div>
        <div class="mt-6 flex justify-center rounded-lg bg-white p-5">{!! $qrSvg !!}</div>
        <div class="mt-5 text-sm">Show this ID for cashier payment, guard verification, and family portal validation.</div>
    </div>
</x-app-layout>
