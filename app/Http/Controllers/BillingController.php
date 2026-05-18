<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(): View
    {
        return view('modules.billing', [
            'billings' => Billing::with(['client', 'lot.section'])->latest()->paginate(20),
            'clients' => Client::orderBy('last_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'type' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:1'],
            'due_date' => ['nullable', 'date'],
        ]);

        Billing::create($data + [
            'billing_number' => 'BIL-'.now()->format('Ymd').'-'.Str::upper(Str::random(5)),
            'paid_amount' => 0,
            'balance' => $data['amount'],
            'status' => 'pending',
        ]);

        return back()->with('status', 'Billing created.');
    }
}
