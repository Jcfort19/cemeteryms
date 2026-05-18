<?php

namespace App\Http\Controllers;

use App\Models\CemeteryLot;
use App\Models\CemeterySection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CemeteryMapController extends Controller
{
    public function index(): View
    {
        return view('modules.map', [
            'sections' => CemeterySection::with('lots.client')->get(),
        ]);
    }

    public function lots(): JsonResponse
    {
        return response()->json(CemeteryLot::with(['section', 'client'])->get());
    }

    public function updateLot(Request $request, CemeteryLot $lot): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:vacant,reserved,occupied,maintenance'],
            'polygon' => ['nullable', 'array'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'notes' => ['nullable', 'string'],
        ]);

        $lot->update($data);

        return response()->json($lot->fresh(['section', 'client']));
    }
}
