<?php

namespace Rudivdme\BearContent\Transformers;

use Rudivdme\BearContent\Transformers\Transformer;

class PageTransformer extends Transformer {

	public function transformRow($item)
	{
		$return = [
			'id'      => $item->id,
			'title'   => $item->title,
			'slug'    => $item->slug,
			'layout'  => $item->layout,
			'private' => $item->private,
			'created' => $item->created_at ? strtolower($item->created_at->format("M j, Y")) : null,
			'status'  => $item->status,
		];

		return $return;
	}

	public function transformShow($item)
	{
		$return = [
			'id'              => $item->id,
			'title'           => $item->title,
			'slug'            => $item->slug,
			'layout'          => $item->layout,
			'private'         => $item->private ? "true":"false",
			'editable_layout' => $item->editable_layout ? "true":"false",
			'linked'          => $item->linked ? "true":"false",
			'created'         => $item->created_at ? strtolower($item->created_at->format("M j, Y")) : null,
			'status'          => $item->status,
		];

		return $return;
	}
}