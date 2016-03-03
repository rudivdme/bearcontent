<?php

namespace Rudivdme\BearContent\Controllers;

use Illuminate\Http\Request;
use Rudivdme\BearContent\Models\Page;

class PageController extends BearController
{
    public function resolve($slug='home')
    {
       	$page = (new Page)->findBySlug($slug);

    	if ($page && $file = snake_case($page->slug))
    	{
            if (view()->exists("pages.$file"))
            {
                return view("pages.$file")->with('page', $page);
            }

    		return view('pages.page')->with('page', $page);
    	}

    	abort(404);
    }
}
