<?php
	if (!function_exists('ba_title'))
	{
		function ba_title($str)
		{
			return $str . " &middot; " . config("bear.title");
		}
	}

	if (!function_exists('shorten'))
	{
		function shorten($str, $length)
		{
			$str = strip_tags($str);

			if (strlen($str) > $length-3) {
				return substr($str, 0, $length-3) . "...";
			}

			return $str;
		}
	}