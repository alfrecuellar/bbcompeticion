<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = ['origin','brand','provider','price'];

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function getPriceAttribute()
    {
        return $this->prices->count() ? $this->prices->first() : null;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getOriginAttribute()
    {
        return $this->tags()->whereHas('parent', function ($query) {
            $query->where('name','origin');
        })->first();
    }

    public function getBrandAttribute()
    {
        return $this->tags()->whereHas('parent', function ($query) {
            $query->where('name','brand');
        })->first();
    }

    public function getProviderAttribute()
    {
        return $this->tags()->whereHas('parent', function ($query) {
            $query->where('name','provider');
        })->first();
    }
}
