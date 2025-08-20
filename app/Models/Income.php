<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'dubbing_id',
        'merzigo_cost',
        'price',
        'unit_price',
        'revenue',
        'income_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'merzigo_cost' => 'decimal:2',
        'price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'revenue' => 'decimal:2',
        'income_date' => 'date',
        'end_date' => 'date',
    ];

    public function dubbing()
    {
        return $this->belongsTo(Dubbing::class);
    }

    // show relation via hasManyThrough is not needed here
}
