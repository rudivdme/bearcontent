<?php

namespace Rudivdme\BearContent\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class BearController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function formatValidationErrors(Validator $validator)
	{
	    return ['result' => false, 'msg' => trans('bear::speak.validation_errors'), 'errors' => $validator->errors()];
	}

	public function __construct()
	{
        
	}
}

