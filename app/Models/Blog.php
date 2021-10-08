<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed banner
 * @property string name
 */
class Blog extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    public $demo = '/uploads/demo.jpg';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string[]
     */
    protected $appends = ['created_at_humans', 'updated_at_humans', 'old_banner'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

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

    /**
     * @return string
     */
    public function getOldBannerAttribute(): string
    {
        return $this->banner ?? '';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * @param $value
     * @return string
     */
    public function setBannerAttribute($value): string
    {
        return $this->attributes['banner'] = !!$value
            ? $value
            : $this->demo;
    }
}
