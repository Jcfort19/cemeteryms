<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\VisitorLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuardTerminalController extends Controller
{
    public function index(): View
    {
        return view('modules.guard', [
            'logs' => VisitorLog::latest()->limit(20)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'client_number' => ['nullable', 'string'],
            'visitor_name' => ['required', 'string', 'max:160'],
            'visitor_phone' => ['nullable', 'string', 'max:40'],
            'purpose' => ['nullable', 'string', 'max:160'],
        ]);

        $client = Client::where('client_number', $data['client_number'] ?? null)->first();

        VisitorLog::create([
            'client_id' => $client?->id,
            'cemetery_lot_id' => $client?->lots()->first()?->id,
            'logged_by' => $request->user()->id,
            'visitor_name' => $data['visitor_name'],
            'visitor_phone' => $data['visitor_phone'] ?? null,
            'purpose' => $data['purpose'] ?? null,
            'entered_at' => now(),
            'verification_snapshot' => $client ? ['client' => $client->full_name] : null,
        ]);

        return back()->with('status', 'Visitor entry logged.');
    }
}
