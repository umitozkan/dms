<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Dubbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'show_id',
        'language_code',
        'studio_id',
        'duration',
        'received_episodes',
        'downloaded_episodes',
        'published_episodes',
        'status',
        'notes',
    ];

    protected $casts = [
        'duration' => 'integer',
        'received_episodes' => 'integer',
        'downloaded_episodes' => 'integer',
        'published_episodes' => 'integer',
    ];

    protected $appends = [];

    protected static function boot()
    {
        parent::boot();
    }

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    // difference attribute removed; pricing is on incomes

    /**
     * Scope to filter dubbings based on user's company access through show relationship
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessibleByUser($query, User $user)
    {
        if ($user->isAdmin()) {
            // Admin can see all dubbings
            return $query;
        }

        // Non-admin users can only see dubbings from their company's shows
        return $query->whereHas('show', function($query) use ($user) {
            $query->where('company_id', $user->company_id);
        });
    }

    /**
     * Check if this dubbing is accessible by a specific user
     * 
     * @param User $user
     * @return bool
     */
    public function isAccessibleByUser(User $user): bool
    {
        // Add null-safety check for show relationship
        if (!$this->relationLoaded('show')) {
            $this->loadMissing('show');
        }
        
        if (!$this->show) {
            return false;
        }
        
        return $user->canAccessCompany($this->show->company_id);
    }

    /**
     * Get the company through the show relationship
     * 
     * @return Company|null
     */
    public function getCompanyAttribute()
    {
        // Add null-safety check for show relationship
        if (!$this->relationLoaded('show')) {
            $this->loadMissing('show');
        }
        
        if (!$this->show) {
            return null;
        }
        
        // Ensure show.company is loaded to prevent N+1
        if (!$this->show->relationLoaded('company')) {
            $this->loadMissing('show.company');
        }
        
        return $this->show->company;
    }
}
