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
        'role',
        'plant',
        'regional',
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
        return in_array($slug, $this->featureCache);
    }

    /**
     * Magic getter: $user->mrc, $user->finansial, dll.
     * Agar sidebar lama ($user->mrc) tetap kompatibel
     */
    public function __get($key)
    {
        $features = [
            'mrc', 'gis', 'lm', 'aigr1', 'garda', 'skyview',
            'operasional', 'aset', 'finansial', 'hr', 'sales',
            'legal', 'progress', 'pengadaan', 'carbon', 'warehouse',
        ];

        if (in_array($key, $features)) {
            return $this->hasFeature($key);
        }

        return parent::__get($key);
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