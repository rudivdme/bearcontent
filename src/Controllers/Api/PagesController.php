<?php

namespace Rudivdme\BearContent\Controllers\Api;

use Illuminate\Http\Request;

use Rudivdme\BearContent\Models\Page;
use Rudivdme\BearContent\Models\Menu;
use App\Http\Requests;
use Rudivdme\BearContent\Controllers\ApiController;
use Rudivdme\BearContent\Transformers\PageTransformer;
use Rudivdme\BearContent\Transformers\MenuTransformer;

class PagesController extends ApiController
{
    /**
     * Return JSON data for the listing of the resource.
     *
     * @return json
     */
    public function index()
    {
        return (new PageTransformer)->data( (new Page)->listQuery() )->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, (new Page)->getRules('create') );

        $record = (new Page)->saveCreate( $request );

        return ['result' => true, 'msg' => 'Looks Good!', 'record' => (new PageTransformer)->data( $record )->single()];
    }

    /**
     * Display the specified resource by JSON.
     *
     * @param  int  $id
     * @return json
     */
    public function show($id)
    {
        return (new PageTransformer)->data( (new Page)->find($id) )->show();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, (new Page)->getRules('update', ['id' => $id]));

        $record = (new Page)->findOrFail($id)->saveUpdate( $request );

        return ['result' => true, 'msg' => 'Looks Good!', 'record' => (new PageTransformer)->data( $record )->single()];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function layout(Request $request, $id)
    {
        $this->validate($request, (new Page)->getRules('layout', ['id' => $id]));

        $record = (new Page)->findOrFail($id);

        if (!empty($record->layout) && $request->input('layout') != $record->layout && !$request->has('confirmed'))
        {
            if ($record->static_layout == true && false)
            {
                return ['result' => false, 'msg' => 'This is a special page and you are not allowed to change the layout.', 'record' => (new PageTransformer)->data( $record )->single()];
            }

            if ($record->status == 'draft')
            {
                return ['result' => false, 'request_confirmation' => true, 'msg' => 'If you change the layout, you could lose content. Are you sure you want to do this?', 'record' => (new PageTransformer)->data( $record )->single()];
            }

            if ($record->status == 'published')
            {
                return ['result' => false, 'request_confirmation' => true, 'msg' => 'If you change the layout, you could lose content. Also it is not advisable to change the layout on a published page. Are you sure you want to do this?', 'record' => (new PageTransformer)->data( $record )->single()];
            }
        }

        $record->saveLayout( $request );

        return ['result' => true, 'msg' => 'Looks Good!', 'record' => (new PageTransformer)->data( $record )->single()];
    }

    /**
     * Display the specified resource by JSON.
     *
     * @param  int  $id
     * @return json
     */
    public function showMenu($id)
    {
        $record = (new PageTransformer)->data( (new Page)->find($id) )->show();

        $menu = (new MenuTransformer)->transformMenu(
            (new Menu)->with('page')->orderBy('sort', 'asc')->get(),
            (new Page)->where('id', '=', $id)->get()
        );

        return $record->merge($menu);
    }

    /**
     * Publish page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function updateMenu(Request $request, $id)
    {
        $record = (new Page)->findOrFail($id);

        if (!empty($request->input('menu')))
        {
            (new Menu)->saveUpdate(json_decode($request->input('menu')));
        }

        return ['result' => true, 'msg' => 'Looks Good!', 'record' => (new PageTransformer)->data( $record )->single()];
    }

    /**
     * Publish page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function publish(Request $request, $id)
    {
        $record = (new Page)->findOrFail($id);

        $record->publish();

        return ['result' => true, 'msg' => 'Page is now published online!', 'record' => (new PageTransformer)->data( $record )->single()];
    }

    /**
     * Unpublish page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function unpublish(Request $request, $id)
    {
        $record = (new Page)->findOrFail($id);

        if ($record->entity != 'content')
        {
            return ['result' => false, 'msg' => 'No you can\'t take down a special page, your site needs it to survive.'];
        }

        $record->unpublish();

        return ['result' => true, 'msg' => 'Page status was set to draft.', 'record' => (new PageTransformer)->data( $record )->single()];
    }

    /**
     * Delete page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function delete(Request $request, $id)
    {
        $record = (new Page)->findOrFail($id);

        if ($record->entity != 'content')
        {
            return ['result' => false, 'msg' => 'No you can\'t just delete this page, your site needs it to survive.'];
        }

        if (!$request->has('confirmed'))
        {
            return ['result' => false, 'request_confirmation' => true, 'msg' => 'Page will be deleted permanently. Are you sure you want to do this?', 'record' => (new PageTransformer)->data( $record )->single()];
        }

        $record->deleteAll();

        return ['result' => true, 'msg' => 'Page was deleted and is now gone!', 'record' => (new PageTransformer)->data( $record )->single()];
    }
}
