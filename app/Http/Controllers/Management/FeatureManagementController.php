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
     * Export features to Excel
     */
    public function export(Request $request)
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        // Fetch all features with their parent eager loaded to avoid N+1 query issues
        $allFeatures = Feature::with('parent')->orderBy('sort_order')->get();
        $featuresByParent = $allFeatures->groupBy('parent_id');
        $roots = $featuresByParent->get(null) ?? collect();

        // Reconstruct the hierarchical tree order in PHP
        $flatFeatures = collect();
        foreach ($roots as $root) {
            $flatFeatures->push($root);
            $children = $featuresByParent->get($root->id) ?? collect();
            foreach ($children as $child) {
                $flatFeatures->push($child);
            }
        }

        // Handle orphans if any exist (safety fallback)
        $addedIds = $flatFeatures->pluck('id')->toArray();
        $orphans = $allFeatures->whereNotIn('id', $addedIds);
        foreach ($orphans as $orphan) {
            $flatFeatures->push($orphan);
        }

        // Apply search filter if requested by the user, while preserving the tree order
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $flatFeatures = $flatFeatures->filter(function ($feature) use ($search) {
                return str_contains(strtolower($feature->slug), $search) ||
                       str_contains(strtolower($feature->name), $search);
            });
        }

        $fileName = 'Export_Manajemen_Fitur_' . date('Y-m-d_His') . '.xls';

        $headers = [
            "Content-type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($flatFeatures) {
            // Write UTF-8 BOM to tell Excel that the file is UTF-8 encoded
            echo "\xEF\xBB\xBF";
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
            
            echo '<table border="1">';
            echo '<tr style="background-color: #16A34A; color: #FFFFFF; font-weight: bold;">';
            echo '<th style="padding: 5px;">No.</th>';
            echo '<th style="padding: 5px;">Nama Fitur</th>';
            echo '<th style="padding: 5px;">Slug</th>';
            echo '<th style="padding: 5px;">Induk (Parent)</th>';
            echo '<th style="padding: 5px;">URL / Rute</th>';
            echo '<th style="padding: 5px;">Sort Order</th>';
            echo '<th style="padding: 5px;">Sidebar</th>';
            echo '<th style="padding: 5px;">Status</th>';
            echo '<th style="padding: 5px;">Created At</th>';
            echo '</tr>';

            $no = 1;
            foreach ($flatFeatures as $feature) {
                $isChild = !empty($feature->parent_id);
                // Indent sub-menus with spaces and tree branch symbol for a better spreadsheet layout
                $displayName = $isChild ? ' &nbsp;&nbsp;&nbsp;&nbsp;└─ ' . htmlspecialchars($feature->name) : htmlspecialchars($feature->name);
                $parentName = $feature->parent ? htmlspecialchars($feature->parent->name) : '-';

                echo '<tr>';
                echo '<td style="text-align: center; padding: 5px;">' . $no++ . '</td>';
                echo '<td style="padding: 5px;">' . $displayName . '</td>';
                echo '<td style="padding: 5px;">' . htmlspecialchars($feature->slug) . '</td>';
                echo '<td style="padding: 5px;">' . $parentName . '</td>';
                echo '<td style="padding: 5px;">' . htmlspecialchars($feature->url ?? '-') . '</td>';
                echo '<td style="text-align: center; padding: 5px;">' . $feature->sort_order . '</td>';
                echo '<td style="text-align: center; padding: 5px;">' . ($feature->is_sidebar ? 'Tampil' : 'Tersembunyi') . '</td>';
                echo '<td style="text-align: center; padding: 5px;">' . ($feature->is_active ? 'Aktif' : 'Nonaktif') . '</td>';
                echo '<td style="padding: 5px;">' . htmlspecialchars($feature->created_at ? $feature->created_at->format('Y-m-d H:i:s') : '-') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new feature
     */
    public function create(): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }
        $parents = Feature::whereNull('parent_id')->orderBy('name')->get();
        return view('management.features.create', compact('parents'));
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
            'parent_id' => 'nullable|exists:features,id',
            'icon' => 'nullable|string|max:100',
            'url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'is_sidebar' => 'required|boolean',
            'is_active' => 'required|boolean',
            'description' => 'nullable|string|max:1000',
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
        $parents = Feature::whereNull('parent_id')->where('id', '!=', $feature->id)->orderBy('name')->get();
        return view('management.features.edit', compact('feature', 'parents'));
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
            'parent_id' => 'nullable|exists:features,id',
            'icon' => 'nullable|string|max:100',
            'url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'is_sidebar' => 'required|boolean',
            'is_active' => 'required|boolean',
            'description' => 'nullable|string|max:1000',
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

    /**
     * Display the feature dictionary as a tree structure
     */
    public function dictionary(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        // Fetch all top-level features with their children sorted by sort_order
        $features = Feature::with(['children' => function ($query) {
            $query->orderBy('sort_order');
        }])
        ->whereNull('parent_id')
        ->orderBy('sort_order')
        ->get();

        return view('management.features.dictionary', compact('features'));
    }
}
