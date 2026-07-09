<?php

// One-off cleanup: merge duplicate/misspelled tags, then drop unused ones.
// Run with: php artisan tinker database/scripts/clean_tags.php

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

$map = [
    'Edit video' => 'Edit Video',
    'Recap Event' => 'Recap',
    'Brand Indentify' => 'Brand Identity',
    'Event Indentify' => 'Event Identity',
    'Shoppe' => 'Shopee',
    'F&b' => 'F&B',
    'Tiktok Video' => 'TikTok Video',
    'SM' => 'Social Media',
    '2D Graphic' => '2D Design',
];

foreach ($map as $from => $to) {
    $src = Tag::where('name', $from)->first();
    if (! $src) {
        continue;
    }

    $dst = Tag::firstOrCreate(['name' => $to]);
    if ($src->id === $dst->id) {
        continue;
    }

    foreach (['project_tag' => 'project_id', 'service_tag' => 'service_id'] as $pivot => $fk) {
        foreach (DB::table($pivot)->where('tag_id', $src->id)->get() as $row) {
            $exists = DB::table($pivot)->where('tag_id', $dst->id)->where($fk, $row->{$fk})->exists();
            if ($exists) {
                DB::table($pivot)->where('id', $row->id)->delete();
            } else {
                DB::table($pivot)->where('id', $row->id)->update(['tag_id' => $dst->id]);
            }
        }
    }

    $src->delete();
    echo "merged: {$from} -> {$to}\n";
}

$orphans = Tag::whereNotIn('id', DB::table('project_tag')->pluck('tag_id'))
    ->whereNotIn('id', DB::table('service_tag')->pluck('tag_id'))
    ->get();

foreach ($orphans as $orphan) {
    echo "deleted unused: {$orphan->name}\n";
    $orphan->delete();
}

echo 'total tags now: '.Tag::count()."\n";
