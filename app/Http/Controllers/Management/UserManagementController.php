<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }

        $query = CustomUser::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");

            });
        }

        $users = $query->paginate(5);
        return view('management.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create(): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        return view('management.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }

        $validated = $request->validate([
            'username' => 'required|unique:users,username|min:3|max:50',
            'password' => 'required|min:6',
            'nik' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:50',
            'plant' => 'nullable|string|max:50',
            'regional' => 'nullable|string|max:50',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        CustomUser::create($validated);

        return redirect()->route('management.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Show the form for editing a user
     */
    public function edit($id): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        $user = CustomUser::findOrFail($id);
        return view('management.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        $user = CustomUser::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|unique:users,username,' . $user->id . '|min:3|max:50',
            'password' => 'nullable|min:6',
            'nik' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:50',
            'plant' => 'nullable|string|max:50',
            'regional' => 'nullable|string|max:50',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('management.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * Delete the specified user
     */
    public function destroy($id): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        $user = CustomUser::findOrFail($id);
        
        $user->delete();

        return redirect()->route('management.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
