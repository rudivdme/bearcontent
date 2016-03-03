<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;
use Rudivdme\BearContent\BearContent;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'layout', 'status', 'linked', 'entity', 'private',
    ];

    public $createRules = [
        'title' => 'required',
        'slug'  => 'required|alpha_dash|unique:pages,slug',
    ];

    public $updateRules = [
        'title' => 'required',
        'slug'  => 'required|alpha_dash|unique:pages,slug,{id}',
    ];

    public $layoutRules = [
        'layout' => 'required',
    ];

	/**
	 * The sections relationship
	 *
	 * @return relation
	 */
	public function sections()
	{
		return $this->hasMany('Rudivdme\BearContent\Models\PageSection')->orderBy('sort', 'asc');
	}

    /**
     * The widgets relationship
     *
     * @return relation
     */
    public function widgets()
    {
        return $this->hasMany('Rudivdme\BearContent\Models\PageWidget')->orderBy('sort', 'asc');
    }

    public function section($type)
    {
        $section = $this->sections->where('type', $type)->first();

        if ($section)
        {
            if ((new BearContent)->loadApp())
            {
                return "<div data-editable data-name='section-".$section->id."'>".$section->content."</div>";
            }
            else
            {
                return $section->content;
            }
        }

        return;
    }

	/**
	 * Find record by slug attribute
	 *
	 * @param  string $slug
	 * @return object
	 */
    public function findBySlug($slug)
    {
        $query = $this->with('sections', 'sections.widgets', 'widgets');

        if (\Auth::check())
        {
            return $query->where('slug', '=', $slug)->first();
        }
        else
        {
            return $query->where('slug', '=', $slug)->where('status', '=', 'published')->first();
        }
    }

    /**
     * Save a complete create request.
     *
     * @param object The request object
     */
    public function saveCreate($request)
    {
        $this->fill( $request->all() );
        $this->status = 'draft';
        $this->entity = 'content';
        if ($request->input('private') == 'true')
        {
            $this->private = true;
            $this->slug = $this->slug . '-' . str_random(30);
        }
        else
        {
            $this->private = false;
        }
        $this->save();

        return $this;
    }

    /**
     * Save a complete update request.
     *
     * @param object The request object
     */
    public function saveUpdate($request)
    {
        $this->fill( $request->all() );

        if ($request->input('private') == 'true')
        {
            $this->private = true;
        }
        else
        {
            $this->private = false;
        }

        $this->save();

        return $this;
    }

    /**
     * Save a complete update request.
     *
     * @param object The request object
     */
    public function saveLayout($request)
    {
        if ($request->input('layout') != $this->layout)
        {
            $this->layout = $request->input('layout');
            $this->save();
        }

        $this->updateAutoSections();

        return $this;
    }

    public function shareMenu()
    {
        view()->share([
            'menu' => (new MenuTransformer)->transformMenu(
                (new Menu)->getMenu(request()->user())
            )
        ]);
    }

    public function shareSlides()
    {
        view()->share([
            'slides' => (new Slide)->getActive()
        ]);
    }

    public function shareRecentSermons()
    {
        view()->share([
            'recent_sermons' => (new Sermon)->getRecent(5)
        ]);
    }

    public function shareUpcomingEvents()
    {
        view()->share([
            'upcoming_events' => (new Event)->getRecent(5)
        ]);
    }

    public function hasFeature()
    {
        return $this->layout == 'home' || $this->layout == 'contact' || strpos($this->layout, "feature") !== false;
    }

    /**
     * Returns a paginated result set, filtered and sorted by criteria in the request.
     *
     * @return object Paginated collection of Eloquent models.
     */
    public function listQuery()
    {
        $query = $this->query();

        // Perform general search across multiple fields
        if (request()->has('filters.search'))
        {
            $search = request('filters.search');
            $query->where(function($q) use ($search) {
                $q->orWhere('id', 'like', "%$search%");
                $q->orWhere('title', 'like', "%$search%");
                $q->orWhere('slug', 'like', "%$search%");
                $q->orWhere('status', 'like', "%$search%");
            });
        }

        if (request()->has('filters.sort'))
        {
        	switch(request('filters.sort'))
        	{
                case 'created':
                    $query->orderBy( 'created_at', request('filters.order') ); break;

        		default:
        			$query->orderBy( request('filters.sort'), request('filters.order') ); break;
        	}
        } else
        {
            $query->orderBy( 'created_at', 'desc' );
        }

        if (request()->has('filters.status'))
        {
            $query->where('status', '=', request('filters.status') );
        }

        if (request()->has('filters.entity'))
        {
            switch(request('filters.entity'))
            {
                case 'all':
                    break;

                case 'special':
                    $query->where('entity', '!=', 'content' ); break;

                case 'content':
                    $query->where('entity', '=', 'content' ); break;
            }

        }
        else
        {
            $query->where('entity', '=', 'content');
        }

        if (request()->has('filters.per_page')) {
            $this->setPerPage(request('filters.per_page'));
        }
        else {
            $this->setPerPage(config('site.per_page'));
        }

        // Query is executed and cannot be changed in the controller. For more flexibility in the controller,
        // return the query before calling paginate.

        $return = $query->paginate( $this->getPerPage() );

        if (request()->has('filters'))
        {
            $return->filters = request('filters');
        }
        else
        {
            $return->filters = ['sort' => 'created', 'order' => 'desc', 'search' => '', 'entity' => 'content'];
        }

        return $return;
    }

    private function getConfigSections()
    {
        foreach (config("bear.layouts") as $layout)
        {
            if ($layout['id'] == $this->layout && !empty($layout['sections']))
            {
                return $layout['sections'];
            }
        }

        return [];
    }

    public function updateAutoSections()
    {
        $ids = [];

        foreach ($this->getConfigSections() as $ix => $type)
        {
            $section = (new PageSection)->withTrashed()->where('type', '=', $type)->where('page_id', '=', $this->id)->first();

            if ($section)
            {
                if ($section->deleted_at)
                {
                    $section->restore();
                }

                $ids[] = $section->id;
            }
            else
            {
                if ($type == 'summary')
                {
                    $content = '<h2>'.$this->title.'</h2>';
                }
                else
                {
                    $content = '<p></p>';
                }

                $section = (new PageSection)->create([
                    'page_id' => $this->id,
                    'type'    => $type,
                    'sort'    => $ix,
                    'content' => $content,
                ]);

                $ids[] = $section->id;
            }
        }

        if (!empty($ids))
        {
            (new PageSection)->where('page_id', '=', $this->id)->whereNotIn('id', $ids)->delete();
        }
    }

    public function deleteAll()
    {
        (new PageSection)->where('page_id', '=', $this->id)->delete();
        (new PageWidget)->where('page_id', '=', $this->id)->delete();
        (new PageImage)->where('page_id', '=', $this->id)->delete();
        (new Menu)->where('page_id', '=', $this->id)->delete();
        $this->delete();
    }

    public function publish()
    {
        $this->status = 'published';
        $this->save();

        (new Menu)->where('page_id', '=', $this->id)->update(['active' => true]);
    }

    public function unpublish()
    {
        $this->status = 'draft';
        $this->save();

        (new Menu)->where('page_id', '=', $this->id)->update(['active' => false]);
    }

    public function getContent()
    {
        $content = "";

        foreach ($this->sections as $section)
        {
            if ( strlen($section->content) > strlen($content))
            {
                $content = $section->content;
            }
        }

        foreach ($this->widgets as $widget)
        {
            if ( strlen($widget->content) > strlen($content))
            {
                $content = $widget->content;
            }
        }

        return $content;
    }

    public function trail()
    {
        if ($this->slug != 'home')
        {
            $return = collect([
                (object)['slug' => $this->slug, 'title' => $this->title]
            ]);
        }

        $menu = (new Menu)->with('parent', 'parent.page')->where('page_id', '=', $this->id)->first();

        if ($menu && $menu->parent)
        {
            $return = $return->merge($menu->parent->page->trail());
        }

        return $return;
    }
}
