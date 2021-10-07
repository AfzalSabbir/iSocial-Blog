<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory, HasFactory;

    protected $appends = ['created_at_humans', 'updated_at_humans'];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return string
     */
    public function getCreatedAtHumansAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * @return string
     */
    public function getUpdatedAtHumansAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }
}
