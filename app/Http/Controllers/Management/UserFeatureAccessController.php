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
     * Export access to Excel
     */
    public function export(Request $request)
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

        $users = $query->get();

        $fileName = 'Export_Manajemen_Akses_' . date('Y-m-d_His') . '.xls';

        $headers = [
            "Content-type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($users) {
            echo '<table border="1">';
            echo '<tr style="background-color: #16A34A; color: #FFFFFF;">';
            echo '<th>No.</th><th>Username</th><th>NIK</th><th>Plant</th><th>Role</th><th>Fitur Akses</th>';
            echo '</tr>';

            foreach ($users as $index => $user) {
                $roleDisplay = $user->role ?? '-';
                if ($user->role === 'admin') $roleDisplay = 'ADMIN';
                elseif ($user->role === 'superadmin') $roleDisplay = 'SUPERADMIN';
                elseif ($user->role === 'viewer_ho' || $user->role === 'viewer_unit') $roleDisplay = 'VIEWER';
                else $roleDisplay = strtoupper($roleDisplay);
                
                $featuresList = $user->features->pluck('name')->implode(', ');

                echo '<tr>';
                echo '<td style="text-align: center;">' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($user->username) . '</td>';
                echo '<td>' . htmlspecialchars($user->nik ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($user->plant ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($roleDisplay) . '</td>';
                echo '<td>' . htmlspecialchars($featuresList ?: 'Tidak ada fitur') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        };

        return response()->stream($callback, 200, $headers);
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
