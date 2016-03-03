<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;

class PageImage extends Model
{
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
		return $this->belongsTo('Rudivdme\BearContent\Models\Section');
	}

	/**
	 * The image relationship
	 *
	 * @return relation
	 */
	public function image()
	{
		return $this->belongsTo('Rudivdme\BearContent\Models\Image', 'image_id');
	}
}
