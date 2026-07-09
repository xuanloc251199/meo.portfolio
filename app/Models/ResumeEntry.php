<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeEntry extends Model
{
    public const TYPE_EDUCATION = 'education';
    public const TYPE_EXPERIENCE = 'experience';

    protected $guarded = [];
}
