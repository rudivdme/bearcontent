<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageSection extends Model
{
	use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'page_id',
        'type',
        'sort',
    ];

    /**
	 * The parent page relationship
	 *
	 * @return relation
	 */
	public function page()
	{
		return $this->belongsTo('Rudivdme\BearContent\Models\Page');
	}

	/**
	 * The widgets relationship
	 *
	 * @return relation
	 */
	public function widgets()
	{
		return $this->hasMany('Rudivdme\BearContent\Models\PageWidget', 'section_id')->orderBy('sort', 'asc');
	}

	/**
	 * The images relationship
	 *
	 * @return relation
	 */
	public function images()
	{
		return $this->hasMany('Rudivdme\BearContent\Models\PageImage', 'section_id')->orderBy('sort', 'asc');
	}

	/**
	 * The feature image relationship
	 *
	 * @return relation
	 */
	public function image()
	{
		return $this->hasOne('Rudivdme\BearContent\Models\PageImage', 'section_id')->orderBy('sort', 'asc');
	}

	public function findWidget($id)
	{
		return $this->widgets->find($id);
	}

}
