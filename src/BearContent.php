<?php

namespace Rudivdme\BearContent;

class BearContent {

	public function loadApp()
	{
		return \Auth::check();
	}

	public function loadLogin()
	{
		return !\Auth::check() && request()->cookie('has-bear') == true;
	}

	public function styles($url="/vendor/bear/css/bear.css")
	{
		if ($this->loadApp() || $this->loadLogin())
        {
            return "<link rel='stylesheet' type='text/css' href='".url($url)."'>";
        }
	}

	public function scripts($url="/vendor/bear/js/bear.js")
	{
		if ($this->loadApp() || $this->loadLogin())
        {
        	return "
            <script type='text/javascript' src='".url($url)."'></script>
			<script>
				(function(){
					BearContent.baseUrl = '".url('/')."';
					BearContent.token = '".csrf_token()."';
					BearContent.msg = '".session('msg')."';
					BearContent.init();
				}).call(this);
			</script>";
        }
	}

	public function classnames()
	{
		if ($this->loadApp() || $this->loadLogin())
        {
        	if ($this->loadLogin())
        	{
        		return 'bear-is-here';
        	}

            return 'has-bear';
        }
	}

}