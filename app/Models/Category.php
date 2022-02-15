<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function childrens(){
        return $this->hasMany(Category::class,'category_id','id',);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
