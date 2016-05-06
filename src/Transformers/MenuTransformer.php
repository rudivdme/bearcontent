<?php

namespace Rudivdme\BearContent\Transformers;

use Rudivdme\BearContent\Transformers\Transformer;

class MenuTransformer extends Transformer {

	public function transformMenu($items, $unlinked=[])
	{
		$menu = [];
		$pages = [];

		foreach ($items as $item)
		{
			if (empty($item->parent_id))
			{
				$item->children = $this->transformSubMenu($item->id, $items);
				$menu[] = $this->transformItem($item);
			}
		}

		foreach ($unlinked as $page)
		{
			$pages[] = $this->transformPage($page);
		}

		return ['menu' => $menu, 'pages' => $pages];
	}

	public function transformSubMenu($id, $items)
	{
		$return = [];

		foreach ($items as $item)
		{
			if (!empty($item->parent_id) && $item->parent_id == $id)
			{
				$item->children = $this->transformSubMenu($item->id, $items);
				$return[] = $this->transformItem($item);
			}
		}

		return $return;
	}

	public function transformItem($item)
	{
		$slug = "";
		$url = "";
		$layout = "";

		if ($item->page)
		{
			$slug = $item->page->slug;
			$url = url($slug);
			$layout = $item->page->layout;
		}
		else
		{
			if ($item->url) {
				$url = $item->url;
			}
			else {
				$url = '#';
			}
		}

		return [
			'id'          => $item->id,
			'title'       => $item->title,
			'page_id'     => $item->page_id,
			'url'         => $item->url,
			'active'      => $item->active,
			'slug'        => $slug,
			'http'        => $url,
			'page_layout' => $layout,
			'current'     => request()->url() == url($url) ? '1' : '0',
			'children'    => $item->children,
		];
	}

	public function transformPage($page)
	{
		return [
			'id'       => $page->id,
			'title'    => $page->title,
			'slug'     => $page->slug,
			'active'   => $page->status == 'published' ? '1' : '0',
		];
	}
}