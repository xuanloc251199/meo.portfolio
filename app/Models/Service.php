<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $guarded = [];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getImageUrlAttribute(): string
    {
        return str_starts_with($this->image, 'img/')
            ? asset($this->image)
            : asset('storage/'.$this->image);
    }
}
