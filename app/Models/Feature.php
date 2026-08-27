<?php
// app/Models/Feature.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Feature extends Model
{
    protected $fillable = ['slug', 'name', 'parent_id', 'icon', 'url', 'sort_order', 'is_sidebar', 'is_active'];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('feature_parent_mapping');
        });

        static::deleted(function () {
            Cache::forget('feature_parent_mapping');
        });
    }

    public function users()
    {
        return $this->belongsToMany(CustomUser::class, 'user_feature', 'feature_id', 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Feature::class, 'parent_id')
                    ->where('is_active', true)
                    ->where('is_sidebar', true)
                    ->orderBy('sort_order');
    }

    public function parent()
    {
        return $this->belongsTo(Feature::class, 'parent_id');
    }

    public function scopeTopLevelSidebar($query)
    {
        return $query->whereNull('parent_id')
                     ->where('is_active', true)
                     ->where('is_sidebar', true)
                     ->orderBy('sort_order');
    }
}
