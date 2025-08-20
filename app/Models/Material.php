<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'dubbing_id',
        'file_type',
        'season_number',
        'episode_number',
        'script_exists',
        'ae_file_exists',
        'file_duration',
        'video_path',
        'script_file_path',
        'ae_file_path',
        'status',
        'duration',
        'studio_start_date',
        'studio_end_date',
        'received_from_producer',
        'unit_price',
        'notes',
    ];

    protected $casts = [
        'script_exists' => 'boolean',
        'ae_file_exists' => 'boolean',
        'duration' => 'integer',
        'file_duration' => 'integer',
        'season_number' => 'integer',
        'episode_number' => 'integer',
        'unit_price' => 'decimal:2',
        'studio_start_date' => 'datetime',
        'studio_end_date' => 'datetime',
        'received_from_producer' => 'datetime',
    ];

    public function dubbing()
    {
        return $this->belongsTo(Dubbing::class);
    }

    // studio relation removed; materials bind only to dubbings per migration
}
