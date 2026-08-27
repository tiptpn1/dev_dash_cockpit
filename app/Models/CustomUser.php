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

        // 2. Pemetaan Sub-Menu ke Parent Menu (untuk Fallback)
        $parentMapping = [
            // Operasional
            'operasional_amanah'       => 'operasional',
            'operasional_dfarm'        => 'operasional',
            'operasional_cctv'         => 'operasional',
            'operasional_onfarmkaret'  => 'operasional',
            'operasional_onfarmteh'    => 'operasional',
            'operasional_onfarmkopi'   => 'operasional',
            'operasional_offfarmkaret' => 'operasional',
            'operasional_offfarmteh'   => 'operasional',
            'operasional_offfarmkopi'  => 'operasional',

            // PICA
            'pica_kuadran'             => 'pica',
            'pica_corrective'          => 'pica',

            // Warehouse
            'warehouse_gudang'         => 'warehouse',

            // Sales
            'sales_overview'           => 'sales',
            'sales_comodities'         => 'sales',
            'sales_tea_inventory'      => 'sales',
            'sales_rubber_delivery'    => 'sales',
            'sales_crm'                => 'sales',
            'sales_sonia'              => 'sales',

            // Aset
            'aset_peta'                => 'aset',
            'aset_recovery'            => 'aset',
            'aset_optimalisasi'        => 'aset',
            'aset_divestasi'           => 'aset',

            // Finansial
            'finansial_console'        => 'finansial',
            'finansial_parent'         => 'finansial',
            'finansial_ratio'          => 'finansial',
            'finansial_executive'      => 'finansial',
            'finansial_sub'            => 'finansial',

            // HR
            'hr_demographics'          => 'hr',
            'hr_dev'                   => 'hr',
            'hr_revenue'               => 'hr',
            'hr_demographic'           => 'hr',
            'hr_sgna'                  => 'hr',

            // Legal
            'legal_tax'                => 'legal',
            'legal_agraria'            => 'legal',

            // Progress
            'progress_sla'             => 'progress',

            // Pengadaan
            'pengadaan_pra'            => 'pengadaan',
            'pengadaan_proses'         => 'pengadaan',
            'pengadaan_kontrak'        => 'pengadaan',
            'pengadaan_stok'           => 'pengadaan',

            // Carbon
            'carbon_emisi'             => 'carbon',

            // GIS
            'gis_areal'                => 'gis',
            'gis_ndvi'                 => 'gis',
            'gis_cuaca'                => 'gis',

            // Skyview
            'skyview_table'            => 'skyview',
            'skyview_exec'             => 'skyview',

            // Laporan Manajemen (LM)
            'lm_13'                    => 'lm',
            'lm_14'                    => 'lm',
            'lm_16'                    => 'lm',
            'lm_34'                    => 'lm',
            'lm_62'                    => 'lm',

            // Pemasaran Karet
            'pemasaran_karet_sales'    => 'pemasaran_karet',
        ];

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