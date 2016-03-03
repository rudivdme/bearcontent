<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;
use Intervention\Image\ImageManagerStatic as ImageTool;

class Image extends Model
{
	public $fillable = ['filename', 'thumbnail', 'extension', 'width', 'height'];

    /**
	 * Save the uploaded image and create a record in the db
	 *
	 * @param   object $request The request object
	 * @return
	 */
	public function saveCreate($request, $th_width=300, $th_height=300)
	{
		$file =  $request->file('file');
		$str = str_random(10);
		$ext = strtolower($file->getClientOriginalExtension());

		$image = ImageTool::make($file)->save(base_path()."/public/uploads/image_$str.$ext");

		$thumb = ImageTool::make($file)
			->fit($th_width, $th_height, function ($c) { $c->aspectRatio(); })
			->save(base_path()."/public/uploads/image_$str"."_thumb.$ext");

		$data = [
			'filename'  => "image_$str.$ext",
			'thumbnail' => "image_$str"."_thumb.$ext",
			'extension' => $ext,
			'width'     => $image->width(),
			'height'    => $image->height(),
		];

		// Create the db record for the image.
		$record = $this->create($data);

		return $record;
	}

	/**
	 * Save the uploaded image and create a record in the db
	 *
	 * @param   object $request The request object
	 * @return
	 */
	public function saveCrop($request, $final_width, $final_height, $th_width=300, $th_height=300)
	{
		$width  = (int)$request->input('width');
		$height = (int)$request->input('height');
		$x      = (int)$request->input('x');
		$y      = (int)$request->input('y');

		$image = ImageTool::make(base_path()."/public/uploads/".$this->filename)
			->crop($width, $height, $x, $y)
			->resize($final_width, $final_height)
			->save(base_path()."/public/uploads/".$this->filename);

		$thumb = ImageTool::make(base_path()."/public/uploads/".$this->filename)
			->fit($th_width, $th_height, function ($c) { $c->aspectRatio(); })
			->save(base_path()."/public/uploads/".$this->thumbnail);

		$data = [
			'width'     => $image->width(),
			'height'    => $image->height(),
		];

		// Create the db record for the image.
		$record = $this->update($data);

		return $record;
	}

	/**
	 * Rotate an image.
	 *
	 * @param  [type] $direction [description]
	 * @return [type]            [description]
	 */
	public function rotate($direction, $th_width=300, $th_height=300)
	{
		$image = ImageTool::make(base_path()."/public/uploads/".$this->filename);

		if ($direction == 'CCW')
		{
			$image->rotate(90);
		}
		else
		{
			$image->rotate(-90);
		}
		$image->save(base_path()."/public/uploads/".$this->filename);

		$thumb = ImageTool::make(base_path()."/public/uploads/".$this->filename)
			->fit($th_width, $th_height, function ($c) { $c->aspectRatio(); })
			->save(base_path()."/public/uploads/".$this->thumbnail);
	}

	/**
	 * Crop an image.
	 *
	 * @param  [type] $direction [description]
	 * @return [type]            [description]
	 */
	public function crop($info, $max_width, $th_width=300, $th_height=300)
	{
		$image = ImageTool::make(base_path()."/public/uploads/".$this->filename);

		$info = explode(',', $info);

		$width = floor(($info[3] - $info[1]) * $this->width);
		$height = floor(($info[2] - $info[0]) * $this->height);
		$x = floor($info[1] * $this->width);
		$y = floor($info[0] * $this->height);

		$image->crop($width, $height, $x, $y);

		if ($image->width() > $max_width)
		{
			$image->resize($max_width, null, function ($c) { $c->aspectRatio(); });
		}

		$image->save(base_path()."/public/uploads/".$this->filename);
		
		$thumb = ImageTool::make(base_path()."/public/uploads/".$this->filename)
			->fit($th_width, $th_height, function ($c) { $c->aspectRatio(); })
			->save(base_path()."/public/uploads/".$this->thumbnail);

		$data = [
			'width'     => $image->width(),
			'height'    => $image->height(),
		];

		// Create the db record for the image.
		$this->update($data);

		return $this;
	}


	/**
	 * Delete record as well as related image files.
	 *
	 * @return null
	 */
	public function deleteAll()
	{
		if (file_exists(base_path()."/public/uploads/".$this->filename))
		{
			unlink(base_path()."/public/uploads/".$this->filename);
		}

		if (file_exists(base_path()."/public/uploads/".$this->thumbnail))
		{
			unlink(base_path()."/public/uploads/".$this->thumbnail);
		}

		$this->delete();
	}
}
