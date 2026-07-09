<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public const TYPE_FORMAT = 'format';
    public const TYPE_CATEGORY = 'category';

    public const TYPE_LABELS = [
        self::TYPE_FORMAT => 'Định dạng',
        self::TYPE_CATEGORY => 'Hạng mục',
    ];

    protected $guarded = [];

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? $this->type;
    }
}
