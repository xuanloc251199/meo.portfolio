<?php

namespace App\Models;

use App\Models\Concerns\HasViTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasViTranslation;

    public const TYPE_LABELS = [
        'design' => 'Design',
        'photography' => 'Photography',
        'video' => 'Video',
        'web' => 'Web',
        'app' => 'App',
        'uiux' => 'UI/UX',
    ];

    protected $guarded = [];

    protected $casts = [
        'opposite' => 'boolean',
        'images' => 'array',
    ];

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? $this->type;
    }

    /**
     * Slides for the PhotoSwipe album: main image first, then album images.
     * Album image sizes are unknown until load (w/h = 0), fixed client-side.
     */
    public function getAlbumItemsAttribute(): array
    {
        [$w, $h] = array_pad(array_map('intval', explode('x', (string) $this->size)), 2, 0);

        $items = [['src' => $this->image_url, 'w' => $w ?: 1400, 'h' => $h ?: 1400]];

        foreach ($this->images ?? [] as $image) {
            $items[] = ['src' => asset('storage/'.$image), 'w' => 0, 'h' => 0];
        }

        return $items;
    }

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
