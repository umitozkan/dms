<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'channelId',
        'name',
        'total_episode',
        'total_duration',
        'type',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function dubbings()
    {
        return $this->hasMany(Dubbing::class);
    }

    /**
     * Scope to filter shows based on user's company access
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessibleByUser($query, User $user)
    {
        if ($user->isAdmin()) {
            // Admin can see all shows
            return $query;
        }

        // Non-admin users can only see shows from their company
        return $query->where('company_id', $user->company_id);
    }

    /**
     * Check if this show is accessible by a specific user
     * 
     * @param User $user
     * @return bool
     */
    public function isAccessibleByUser(User $user): bool
    {
        return $user->canAccessCompany($this->company_id);
    }
}
