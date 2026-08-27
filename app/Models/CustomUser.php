<?php
// app/Models/CustomUser.php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CustomUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'phone',
        'nik',
        'organization',
        'role',
        'plant',
        'regional',
        'last_login_at',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Relasi many-to-many ke tabel features via user_feature
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'user_feature', 'user_id', 'feature_id');
    }

    /**
     * Cache slug fitur yang dimiliki user (lazy load sekali saja)
     */
    protected ?array $featureCache = null;

    protected function loadFeatureCache(): void
    {
        if ($this->featureCache === null) {
            $this->featureCache = $this->features()->pluck('slug')->toArray();
        }
    }

    /**
     * Cek apakah user memiliki akses ke fitur tertentu
     * Contoh: $user->hasFeature('mrc')
     */
    public function hasFeature(string $slug): bool
    {
        $this->loadFeatureCache();

        // 1. Cek akses langsung dari database
        if (in_array($slug, $this->featureCache)) {
            return true;
        }

        // 2. Pemetaan Sub-Menu ke Parent Menu dari database (cached)
        $parentMapping = \Illuminate\Support\Facades\Cache::rememberForever('feature_parent_mapping', function () {
            return \Illuminate\Support\Facades\DB::table('features')
                ->whereNotNull('features.parent_id')
                ->join('features as parents', 'features.parent_id', '=', 'parents.id')
                ->select('features.slug as child_slug', 'parents.slug as parent_slug')
                ->pluck('parent_slug', 'child_slug')
                ->toArray();
        });

        // Case B: Jika parameter yang dicek adalah SUB-MENU, fallback ke Parent Menu
        if (isset($parentMapping[$slug])) {
            $parentSlug = $parentMapping[$slug];
            if (in_array($parentSlug, $this->featureCache)) {
                return true;
            }
        }

        // Tambahan khusus untuk legacy standalone features yang berubah menjadi sub-menu
        if ($slug === 'sales_sonia' && in_array('sonia', $this->featureCache)) {
            return true;
        }
        if ($slug === 'operasional_cctv' && in_array('cctv', $this->featureCache)) {
            return true;
        }
        if ($slug === 'management_lastlogin' && in_array('management_access', $this->featureCache)) {
            return true;
        }
        if ($slug === 'management_features_dictionary' && in_array('management_features', $this->featureCache)) {
            return true;
        }

        // Case C: Jika parameter yang dicek adalah PARENT MENU, buka jika user punya minimal salah satu sub-menunya
        // Contoh: Cek 'hr', tetapi user hanya punya 'hr_dev' di DB
        $subFeatures = array_keys($parentMapping, $slug);
        if (!empty($subFeatures)) {
            foreach ($subFeatures as $subFeature) {
                if (in_array($subFeature, $this->featureCache)) {
                    return true;
                }
            }
        }

        return false;
    }



    // ─── AuthenticatableContract helpers ───────────────────────────────────

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }

    public function setRememberToken($value): void
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }
}