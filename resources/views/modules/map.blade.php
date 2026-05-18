<x-app-layout>
    <x-slot name="header">Cemetery Polygon Map</x-slot>
    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    @endpush
    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
        <div class="overflow-hidden rounded-lg border border-white/10 bg-[#11212D]">
            <div id="cemetery-map" class="h-[70vh] min-h-[520px]"></div>
        </div>
        <aside class="rounded-lg border border-white/10 bg-white/8 p-5">
            <h2 class="text-lg font-semibold text-white">Lot Indicators</h2>
            <div class="mt-4 space-y-3 text-sm">
                @foreach (['vacant' => 'bg-emerald-400', 'reserved' => 'bg-amber-300', 'occupied' => 'bg-rose-400', 'maintenance' => 'bg-[#9BA8AB]'] as $status => $color)
                    <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full {{ $color }}"></span>{{ ucfirst($status) }}</div>
                @endforeach
            </div>
            <div class="mt-6 text-sm text-[#9BA8AB]">Click a lot polygon to view owner, section, price, and status. Semi Admin users can update lot shapes through the JSON API route.</div>
        </aside>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const map = L.map('cemetery-map').setView([8.165, 125.99], 18);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 21 }).addTo(map);
            const colors = { vacant: '#34d399', reserved: '#fcd34d', occupied: '#fb7185', maintenance: '#9BA8AB' };
            const lots = await fetch('{{ route('map.lots') }}').then(r => r.json());
            lots.forEach(lot => {
                if (!lot.polygon || !Array.isArray(lot.polygon)) return;
                const layer = L.polygon(lot.polygon, { color: colors[lot.status] || '#CCD0CF', weight: 2, fillOpacity: .42 }).addTo(map);
                layer.bindPopup(`<strong>${lot.section?.code || ''}-${lot.lot_number}</strong><br>${lot.status}<br>${lot.client?.first_name || 'No owner'} ${lot.client?.last_name || ''}`);
            });
        });
    </script>
</x-app-layout>
