<?php

namespace Rudivdme\BearContent\Controllers;

use Illuminate\Http\Request;
use Rudivdme\BearContent\Models\Page;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
    public function resolve($slug='home')
    {
       	$page = (new Page)->findBySlug($slug);

    	if ($page && $file = snake_case($page->slug))
    	{
            $page->shareMenu();

            if (view()->exists("pages.$file"))
            {
                return view("pages.$file")->with('page', $page);
            }

    		return view('pages.page')->with('page', $page);
    	}

    	abort(404);
    }
}
