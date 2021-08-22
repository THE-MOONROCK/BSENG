<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content'
    ];
    protected $hidden = ['deleted_at'];
    public $incrementing = false;
    // protected $appends = ['featured_image', 'featured_image_link', 'featured_image_url',  'attachment_link', 'attachment_url', 'video_link_url'];
    protected $with = [];

    public function getFeaturedImageAttribute()
    {
        return $this->getFirstMedia('featured_image');
    }

    public function getFeaturedImageLinkAttribute()
    {
        $file = $this->getFirstMedia('featured_image');
        if (! $file) {
            return null;
        }

        return '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
    }

    public function getFeaturedImageUrlAttribute()
    {
        $file = $this->getFirstMedia('featured_image');

        return url($file->getUrl());
    }

    public function getAttachmentLinkAttribute()
    {
        $attachments = $this->getMedia('attachment');
        if (! count($attachments)) {
            return null;
        }
        $html = [];
        foreach ($attachments as $file) {
            $html[] = '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
        }

        return implode('<br/>', $html);
    }

    public function getAttachmentUrlAttribute()
    {
        $attachments = $this->getMedia('attachment');
        if (! count($attachments)) {
            return null;
        }
        $html = [];
        foreach ($attachments as $file) {
            $html[] =  $file->getUrl();
        }

        return implode('<br/>', $html);
    }

    public function getVideoLinkUrlAttribute()
    {
        $html[] = '<a href="' .$this->video_link . '" target="_blank">' . $this->video_link . '</a>';
        return implode('<br/>', $html);
    }
}
