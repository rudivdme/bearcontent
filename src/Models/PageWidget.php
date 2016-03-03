<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;

class PageWidget extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'page_id', 'section_id', 'type', 'sort'
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
	 * The parent section relationship // Optional
	 *
	 * @return relation
	 */
	public function section()
	{
		return $this->belongsTo('Rudivdme\BearContent\Models\PageSection');
	}
}
