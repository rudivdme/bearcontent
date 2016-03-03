<?php

	Route::group(['middleware' => 'web', 'namespace' => 'Rudivdme\BearContent\Controllers'], function() {

		Route::post('bear/login', 'Api\AuthController@login');

		Route::group(['prefix' => 'bear'], function() {

			Route::post('logout', 'Api\AuthController@logout');

			Route::post('save', 'Api\SaveController@update');
			Route::post('image', 'Api\SaveController@image');
			Route::post('image/rotate', 'Api\SaveController@rotate');
			Route::post('image/crop', 'Api\SaveController@crop');
			Route::post('image/insert', 'Api\SaveController@insert');
			Route::post('pages', 'Api\PagesController@index');
			Route::post('pages/create', 'Api\PagesController@store');
			Route::post('pages/{id}', 'Api\PagesController@show');
			Route::post('pages/{id}/edit', 'Api\PagesController@update');
			Route::post('pages/{id}/layout', 'Api\PagesController@layout');
			Route::post('pages/{id}/menu', 'Api\PagesController@showMenu');
			Route::post('pages/{id}/menu/update', 'Api\PagesController@updateMenu');
			Route::post('pages/{id}/publish', 'Api\PagesController@publish');
			Route::post('pages/{id}/unpublish', 'Api\PagesController@unpublish');
			Route::post('pages/{id}/delete', 'Api\PagesController@delete');

			Route::post('menu', 'Api\MenuController@index');
			Route::post('menu/save', 'Api\MenuController@update');

		});

		Route::get('admin', function() {
			return redirect('/')->withCookie(cookie()->forever('has-bear', true));
		});

		Route::get('exit', function() {
			\Auth::logout();
			return redirect('/')->withCookie(cookie()->forget('has-bear'));
		});

		Route::get('{slug}', 	'PageController@resolve');
		Route::get('/', 		'PageController@resolve');

	});


	if (!function_exists('ba_title'))
	{
		function ba_title($str)
		{
			return $str . " &middot; " . config("bear.title");
		}
	}