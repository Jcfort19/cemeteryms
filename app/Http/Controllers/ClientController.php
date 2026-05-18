<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\QrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        return view('modules.clients', [
            'clients' => Client::with(['lots.section'])->latest()->paginate(20),
        ]);
    }

    public function store(Request $request, QrCodeService $qrCode): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'middle_name' => ['nullable', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $client = Client::create($data + [
            'client_number' => 'CL-'.now()->format('Ymd').'-'.Str::upper(Str::random(5)),
            'qr_token' => Str::random(48),
            'qr_issued_at' => now(),
            'portal_enabled' => true,
        ]);

        $qrCode->issue($client);

        return back()->with('status', 'Client record created.');
    }
}
