<?php

namespace App\Models;

use App\Models\Category;
use App\Models\User;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function category()
    {
        return $this->belongsto(Category::class);
    }

    public function user()
    {
        return $this->belongsto(User::class);
    }

    public function scopeWithOrder($query,$order)
    {
        switch ($order) {
            case 'recent':
                # code...
                $query->recent();
                break;

            default:
                # code...
                $query->recentReplied();
                break;
        }

        return $query->with('user','category');
    }

    public function scopeRecentReplied($query)
    {
        return  $query->orderBy('updated_at','desc');
    }

    public function scopeRecent($query)
    {
        return  $query->orderBy('created_at','desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}