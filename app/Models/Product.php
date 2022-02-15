<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends  Model implements HasMedia
{
    use HasFactory ,InteractsWithMedia,Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = [
        'gallery',
    ];

     /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getGalleryAttribute()
    {
        $files = $this->getMedia('gallery');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
        });

        return $files;
    }

    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] == 0 ? 'Inactive' : 'Active';
    }

    public function getFeaturedAttribute(): string
    {
        return $this->attributes['featured'] == 0 ? 'No' : 'Yes';
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function scopeHasQuantity($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

}
