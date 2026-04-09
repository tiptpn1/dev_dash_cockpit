<?php
// app/Models/Plant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    /**
     * Nama tabel di database
     */
    protected $table = 'm_plant';

    /**
     * Kolom yang boleh diisi secara massal
     */
    protected $fillable = [
        'regional',
        'plant',
        'nama',
    ];

    /**
     * Relasi: satu plant punya banyak user
     */
    public function users()
    {
        return $this->hasMany(CustomUser::class, 'plant', 'plant');
    }
}
