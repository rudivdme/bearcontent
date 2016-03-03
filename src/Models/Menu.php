<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'page_id', 'parent_id', 'sort', 'active', 'url',
    ];

    /**
     * The page relationship
     *
     * @return relation
     */
    public function page()
    {
        return $this->belongsTo('Rudivdme\BearContent\Models\Page');
    }
    /**
     * The parent relationship
     *
     * @return relation
     */
    public function parent()
    {
        return $this->belongsTo('Rudivdme\BearContent\Models\Menu', 'parent_id');
    }

    public function getMenu($user=false)
    {
        if ($user)
        {
            return $this->query()->with('page')->orderBy('sort', 'asc')->get();
        }

        return $this->query()->with('page')->where('active', '=', 1)->orderBy('sort', 'asc')->get();
    }

    /**
     * Save a complete update request.
     *
     * @param object The request object
     */
    public function saveUpdate($arr)
    {
        $ids = [];
        $page_ids = [];

        foreach ($arr as $ix => $row)
        {
            if (strpos($row->id, "new")===false)
            {
                $parent = $this->find($row->id);

                if ($parent)
                {
                    $parent->parent_id = null;
                    $parent->title     = $row->title;
                    $parent->page_id   = $row->pageId;
                    $parent->sort      = $ix;
                    $parent->active    = $row->active;
                    $parent->url       = $row->url;
                    $parent->save();

                    $ids[] = $parent->id;

                    if ($parent->page_id)
                    {
                        $page_ids[] = $parent->page_id;
                    }

                    $this->saveChildren($row, $parent, $ids, $page_ids);
                }
            }
            else
            {
                $parent = new Menu([
                    'parent_id' => null,
                    'title'     => $row->title,
                    'page_id'   => $row->pageId,
                    'sort'      => $ix,
                    'active'    => $row->active,
                    'url'       => $row->url,
                ]);

                $parent->save();

                $ids[] = $parent->id;

                if ($parent->page_id)
                {
                    $page_ids[] = $parent->page_id;
                }

                $this->saveChildren($row, $parent, $ids, $page_ids);
            }
        }

        if (!empty($ids))
        {
            $this->query()->whereNotIn('id', $ids)->delete();
        }

        if (!empty($page_ids))
        {
            (new Page)->whereNotIn('id', $page_ids)->update(['linked' => 0]);
            (new Page)->whereIn('id', $page_ids)->update(['linked' => 1]);
        }

        return $this;
    }

    public function saveChildren($row, $parent, &$ids, &$page_ids)
    {
        if (!empty($row->children))
        {
            foreach ($row->children as $ixx => $item)
            {
                if (strpos($item->id, "new")===false)
                {
                    $child = $this->find($item->id);

                    if ($child)
                    {
                        $child->parent_id = $parent->id;
                        $child->title     = $item->title;
                        $child->page_id   = $item->pageId;
                        $child->sort      = $ixx;
                        $child->active    = $item->active;
                        $child->url       = $item->url;
                        $child->save();

                        $ids[] = $child->id;

                        if ($child->page_id)
                        {
                            $page_ids[] = $child->page_id;
                        }
                    }
                }
                else
                {
                    $child = new Menu([
                        'parent_id' => $parent->id,
                        'title'     => $item->title,
                        'page_id'   => $item->pageId,
                        'sort'      => $ixx,
                        'active'    => $item->active,
                        'url'       => $item->url,
                    ]);

                    $child->save();

                    $ids[] = $child->id;

                    if ($child->page_id) {
                        $page_ids[] = $child->page_id;
                    }
                }
            }
        }
    }
}
