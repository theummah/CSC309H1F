<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Format Return
 *
 * Return an array indicating success, failure, and a brief description if necessary
 * SUCCESS CODE: GOOD
 * FAILURE CODE: BAD
 *
 * @access	public
 * @param	string
 * @return	array
 */
if ( ! function_exists('format_return'))
{
	function format_return($status, $statement = NULL)
	{

		if (strtolower($status) == "good"){
			$status = "GOOD";
		}
		else if (strtolower($status) == "bad"){
			$status = "BAD";
		}

		return array(
				'status' => $status,
				'message' => $statement
			);
	}
}

/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */