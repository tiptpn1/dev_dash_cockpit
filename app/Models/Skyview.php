<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skyview extends Model
{
    use HasFactory;

    protected $table = 'skyviews';

    protected $fillable = [
        'kebun_unit',
        'tanggal',
        'link_youtube',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Extract YouTube video ID from various YouTube URL formats.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = $this->link_youtube;
        if (!$url) return null;

        // youtube.com/watch?v=VIDEO_ID
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }
        // youtu.be/VIDEO_ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }
        // youtube.com/embed/VIDEO_ID
        if (preg_match('/embed\/([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    /**
     * Get YouTube embed URL.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }

    /**
     * Get YouTube thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id ? "https://img.youtube.com/vi/{$id}/mqdefault.jpg" : null;
    }
}
