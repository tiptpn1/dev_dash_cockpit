<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Feature;

class SidebarComposer
{
    public function compose(View $view)
    {
        $user = Auth::guard('custom')->user();
        if (!$user) {
            return;
        }

        // Ambil semua menu level teratas beserta sub-menunya yang aktif
        $topLevelFeatures = Feature::with('children')->topLevelSidebar()->get();

        // Saring menu berdasarkan hak akses pengguna
        $filteredMenus = $topLevelFeatures->filter(function ($menu) use ($user) {
            if ($menu->children->isNotEmpty()) {
                // Tampilkan menu induk jika pengguna memiliki hak akses ke minimal salah satu sub-menunya
                return $menu->children->contains(function ($child) use ($user) {
                    return $user->hasFeature($child->slug);
                });
            }
            // Tampilkan jika ini menu mandiri dan pengguna memiliki hak aksesnya
            return $user->hasFeature($menu->slug);
        });

        $view->with('sidebarMenus', $filteredMenus);
    }
}
