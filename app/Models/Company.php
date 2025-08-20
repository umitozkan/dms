<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'source',
        ];

    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    public function dubbings()
    {
        return $this->hasManyThrough(Dubbing::class, Show::class);
    }

    /**
     * Scope to filter companies based on user access
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessibleByUser($query, User $user)
    {
        if ($user->isAdmin()) {
            // Admin can see all companies
            return $query;
        }

        // Non-admin users can only see their own company
        return $query->where('id', $user->company_id);
    }

    /**
     * Check if this company is accessible by a specific user
     *
     * @param User $user
     * @return bool
     */
    public function isAccessibleByUser(User $user): bool
    {
        return $user->canAccessCompany($this);
    }
}
