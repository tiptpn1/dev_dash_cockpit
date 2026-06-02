<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FeatureManagementController extends Controller
{
    /**
     * Display a listing of features
     */
    public function index(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $query = Feature::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $features = $query->paginate(5);
        return view('management.features.index', compact('features'));
    }

    /**
     * Show the form for creating a new feature
     */
    public function create(): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }
        return view('management.features.create');
    }

    /**
     * Store a newly created feature
     */
    public function store(Request $request): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $validated = $request->validate([
            'slug' => 'required|unique:features,slug|min:2|max:50|alpha_dash',
            'name' => 'required|string|max:100',
        ]);

        Feature::create($validated);

        return redirect()->route('management.features.index')
            ->with('success', 'Feature berhasil ditambahkan');
    }

    /**
     * Show the form for editing a feature
     */
    public function edit(Feature $feature): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }
        return view('management.features.edit', compact('feature'));
    }

    /**
     * Update the specified feature
     */
    public function update(Request $request, Feature $feature): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $validated = $request->validate([
            'slug' => 'required|unique:features,slug,' . $feature->id . '|min:2|max:50|alpha_dash',
            'name' => 'required|string|max:100',
        ]);

        $feature->update($validated);

        return redirect()->route('management.features.index')
            ->with('success', 'Feature berhasil diupdate');
    }

    /**
     * Delete the specified feature
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        // Hapus relasi dengan users
        $feature->users()->detach();
        $feature->delete();

        return redirect()->route('management.features.index')
            ->with('success', 'Feature berhasil dihapus');
    }
}
