<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $guarded = [];

    public function getIconUrlAttribute(): string
    {
        return str_starts_with($this->icon, 'img/')
            ? asset($this->icon)
            : asset('storage/'.$this->icon);
    }
}
