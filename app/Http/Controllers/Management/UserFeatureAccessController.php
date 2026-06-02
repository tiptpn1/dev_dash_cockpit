<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserFeatureAccessController extends Controller
{
    /**
     * Display users with their features assignment
     */
    public function index(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }

        $query = CustomUser::with('features');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(5);
        return view('management.access.index', compact('users'));
    }

    /**
     * Show form to assign features to a specific user
     */
    public function edit($id): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }
        $user = CustomUser::findOrFail($id);

        $allFeatures = Feature::all();
        $userFeatures = $user->features->pluck('id')->toArray();

        return view('management.access.edit', compact('user', 'allFeatures', 'userFeatures'));
    }

    /**
     * Update features for a user
     */
    public function update(Request $request, $id): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }
        $user = CustomUser::findOrFail($id);

        $validated = $request->validate([
            'features' => 'array',
            'features.*' => 'exists:features,id',
        ]);

        $features = $validated['features'] ?? [];

        // Sync features (remove old, add new)
        $user->features()->sync($features);

        return redirect()->route('management.access.index')
            ->with('success', 'Hak akses user berhasil diupdate');
    }

    /**
     * Bulk update features for multiple users
     */
    public function bulkUpdate(Request $request): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }

        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'features' => 'array',
            'features.*' => 'exists:features,id',
            'action' => 'required|in:assign,remove,replace',
        ]);

        $features = $validated['features'] ?? [];
        $users = CustomUser::whereIn('id', $validated['user_ids'])->get();

        foreach ($users as $user) {
            if ($validated['action'] === 'assign') {
                $user->features()->attach($features);
            } elseif ($validated['action'] === 'remove') {
                $user->features()->detach($features);
            } elseif ($validated['action'] === 'replace') {
                $user->features()->sync($features);
            }
        }

        return redirect()->route('management.access.index')
            ->with('success', 'Hak akses berhasil diupdate untuk ' . count($users) . ' user');
    }

    /**
     * Quick toggle feature for a user (AJAX)
     */
    public function toggleFeature(Request $request, $id, Feature $feature)
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }
        $user = CustomUser::findOrFail($id);

        if ($user->features()->where('feature_id', $feature->id)->exists()) {
            $user->features()->detach($feature->id);
            return response()->json(['status' => 'removed', 'message' => 'Feature dihapus']);
        } else {
            $user->features()->attach($feature->id);
            return response()->json(['status' => 'added', 'message' => 'Feature ditambahkan']);
        }
    }
}
