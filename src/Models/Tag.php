<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag', 'count', 'slug', 'type'
    ];

    public function findSeries($slug)
    {
    	return $this->where('type', '=', 'series')->where('slug', '=', $slug)->first();
    }

    public function findPreacher($slug)
    {
    	return $this->where('type', '=', 'preacher')->where('slug', '=', $slug)->first();
    }

    public function findTag($slug)
    {
    	return $this->where('type', '=', 'tag')->where('slug', '=', $slug)->first();
    }
}