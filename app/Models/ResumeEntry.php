<?php

namespace App\Models;

use App\Models\Concerns\HasViTranslation;
use Illuminate\Database\Eloquent\Model;

class ResumeEntry extends Model
{
    use HasViTranslation;

    public const TYPE_EDUCATION = 'education';
    public const TYPE_EXPERIENCE = 'experience';

    protected $guarded = [];
}
