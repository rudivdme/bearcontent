<?php

namespace Rudivdme\BearContent\Transformers;

abstract class Transformer {

	protected $data;

	/**
	 * Receives the data that will be tranformed.
	 *
	 * @param   object $data Most likely an Eloquent object or collection of Eloquent objects.
	 * @return  object       Instance of self.
	 */
	public function data($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Transforms a paginated list.
	 *
	 * @return object  The collection of transformed data.
	 */
	public function paginate()
	{
		$data = $this->data;

		$paginator = [
			'total'         => $data->total(),
            'per_page'      => $data->perPage(),
            'current_page'  => $data->currentPage(),
            'last_page'     => $data->lastPage(),
            'next_page_url' => $data->nextPageUrl(),
            'prev_page_url' => $data->previousPageUrl(),
            'from'          => $data->firstItem(),
            'to'            => $data->lastItem(),
		];

		$filters = !empty($data->filters) ? $data->filters : [];

		return collect(['paginator' => $paginator, 'records' => $this->transformIndex( $data->items() ), 'filters' => $filters ]);
	}

	/**
	 * Transforms a non-paginated list.
	 *
	 * @return object  The collection of transformed data.
	 */
	public function index()
	{
		$data = $this->data;

		$filters = !empty($data->filters) ? $data->filters : [];

		return collect(['loaded' => true, 'records' => $this->transformIndex( $data ), 'filters' => $filters ]);
	}

	/**
	 * Transforms a non-paginated list.
	 *
	 * @return object  The collection of transformed data.
	 */
	public function arr()
	{
		$data = $this->data;

		return $this->transformIndex( $data );
	}

	/**
	 * Transforms a partial record.
	 *
	 * @return object  The collection of transformed data.
	 */
	public function create()
	{
		$data = $this->data;

		return collect(['record' => $this->transformCreate( $data ) ]);
	}

	/**
	 * Transforms a single record.
	 *
	 * @return object  The collection of transformed data.
	 */
	public function show()
	{
		$data = $this->data;

		return collect(['record' => $this->transformShow( $data ) ]);
	}

	/**
	 * Transforms a single record.
	 *
	 * @return object  The collection of transformed data.
	 */
	public function single()
	{
		$data = $this->data;

		return $this->transformShow( $data );
	}

	public function transformIndex($items)
	{
		$return = [];

		foreach ($items as $item)
		{
			$return[] = $this->transformRow($item);
		}

		return $return;
	}

	/**
	 * For use in the transformer when a records has a property containing an array of relations.
	 *
	 * @param  string  $method    The name of the transform method to call.
	 * @param  array   $item      The array of data to transform.
	 * @return [type]             [description]
	 */
	protected function multiple($method, $items)
	{
		$return = [];

		foreach ($items as $item)
		{
			$return[] = $this->$method( $item );
		}

		return $return;
	}

}