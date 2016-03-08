<?php

namespace Rudivdme\BearContent\Controllers\Api;

use Illuminate\Http\Request;

use Rudivdme\BearContent\Models\Page;
use Rudivdme\BearContent\Models\PageSection;
use Rudivdme\BearContent\Models\PageWidget;
use Rudivdme\BearContent\Models\Image as Image;
use App\Http\Requests;
use Rudivdme\BearContent\Controllers\ApiController;
use Rudivdme\BearContent\Transformers\PageTransformer;

class SaveController extends ApiController
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->except('_token');

        if (count($input) > 0)
        {
            foreach ($input as $key => $content)
            {
                $arr = explode('-', $key);

                $type = $arr[0];
                $id = $arr[1];

                switch($type)
                {
                    case 'section':
                        $record = PageSection::where('id', '=', $id)->first(); break;
                    case 'widget':
                        $record = PageWidget::where('id', '=', $id)->first(); break;
                    case 'page':
                        $record = Page::where('id', '=', $id)->first(); break;
                }
                if (!empty($record)) {
                    $record->fill(['content' => $content])->save();
                }
            }

            return ['result' => true, 'msg' => 'Looks Good!'];
        }

        return ['result' => false, 'msg' => 'Nothing to update.'];
    }

    /**
     * Upload an image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request)
    {
        $input = $request->all();

        $record = (new Image)->saveCreate($request);

        return ['result' => true, 'msg' => 'Looks Good!', 'record' => $record];
    }

    /**
     * Rotate an image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rotate(Request $request)
    {
        $input = $request->all();

        $record = (new Image)->findOrFail($input['id']);

        $record->rotate($input['direction']);

        return ['result' => true, 'msg' => 'Looks Good!', 'record' => $record];
    }

    /**
     * Insert an image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request)
    {
        $input = $request->all();

        $record = (new Image)->findOrFail($input['id']);

        $record = $record->crop($input['crop'], $input['width']);

        return ['result' => true, 'msg' => 'Looks Good!', 'record' => $record];
    }

}
