<?php

namespace App\Models;

use App\Models\Concerns\HasViTranslation;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasViTranslation;

    protected $guarded = [];
}
