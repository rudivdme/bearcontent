<?php

namespace Rudivdme\BearContent\Controllers\Api;

use Illuminate\Http\Request;

use Rudivdme\BearContent\Models\Page;
use Rudivdme\BearContent\Models\Menu;
use App\Http\Requests;
use Rudivdme\BearContent\Controllers\ApiController;
use Rudivdme\BearContent\Transformers\MenuTransformer;

class MenuController extends ApiController
{
    /**
     * Return JSON data for the listing of the resource.
     *
     * @return json
     */
    public function index()
    {
        return (new MenuTransformer)->transformMenu( 
            (new Menu)->with('page')->orderBy('sort', 'asc')->get(),
            (new Page)->where('linked', '=', false)->orderBy('title', 'asc')->get()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function update(Request $request)
    {
    	if (!empty($request->input('menu')))
    	{
        	(new Menu)->saveUpdate(json_decode($request->input('menu')));
        }

        return ['result' => true, 'msg' => 'Looks Good!'];
    }

}
