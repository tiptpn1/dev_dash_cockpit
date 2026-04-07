<?php
// app/Models/Feature.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['slug', 'name'];

    public function users()
    {
        return $this->belongsToMany(CustomUser::class, 'user_feature', 'feature_id', 'user_id');
    }
}
