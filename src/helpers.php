<?php
	if (!function_exists('ba_title'))
	{
		function ba_title($str)
		{
			return $str . " &middot; " . config("bear.title");
		}
	}