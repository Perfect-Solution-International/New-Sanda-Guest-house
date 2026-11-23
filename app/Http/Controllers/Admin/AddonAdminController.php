<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddonAdminController extends Controller
{
    public function index(): View
    {
        $addons = Addon::all();
        return view('admin.addons.index', compact('addons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:per_booking,per_person,per_night',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        Addon::create($validated);

        return redirect()->route('admin.addons.index')->with('success', 'Addon / Tour service added successfully!');
    }

    public function update(Request $request, Addon $addon): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:per_booking,per_person,per_night',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $addon->update($validated);

        return redirect()->route('admin.addons.index')->with('success', 'Addon updated successfully!');
    }

    public function destroy(Addon $addon): RedirectResponse
    {
        $addon->delete();
        return redirect()->route('admin.addons.index')->with('success', 'Addon deleted.');
    }
}
