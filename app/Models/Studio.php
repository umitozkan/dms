<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'source',
        'unit_price',
        'address',
        'country',
        'contact_person',
        'phone',
        'email',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    public function dubbings()
    {
        return $this->hasMany(Dubbing::class);
    }

    public function materials()
    {
        return $this->hasManyThrough(Material::class, Dubbing::class);
    }
}
