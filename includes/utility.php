<?php
/*
	Utility functions
*/
class UTILITY
{
	//Constructor
	function  __construct(){}

	//Bind result array
	function bind_result_array($stmt)
	{
		$meta = $stmt->result_metadata();
		$result = array();
		while($field = $meta->fetch_field())
		{
			$result[$field->name] = NULL;
			$params[] = &$result[$field->name];
		}
		call_user_func_array(array($stmt, 'bind_result'), $params);
		return $result;
	}

	//Get copy of array references
	function getCopy($row)
	{
		return array_map(create_function('$a', 'return $a;'), $row);
	}

	//Random password generator
	function rand_pass_gen($length)
	{
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwzxyz\$_?()*&^%#@!-0123456789";
		$charArr = str_split($chars);
		$result = "";
		for($i=0; $i<$length; $i++)
		{
			//returns the index of the random char
			$rand_char = array_rand($charArr);
			//concatenate the char into new string
			$result .= "" . $charArr[$rand_char];
		}
		return $result;
	}

	//Prints error message and redirects to a webpage
	function print_msg($message, $redirect)
	{
		echo "<script type='text/javascript'>
				alert('".$message."');
				window.location.replace('".$redirect."');
			</script>";
	}

	//Create slug for URLs
	//Rewrite in .htaccess to display SEO URLs instead
	function gen_slug($url)
	{
		//prepare string with basic normalization
		$url = strtolower($url);
		$url = strip_tags($url);
		$url = stripslashes($url);
		$url = html_entity_decode($url);
		//Remove any quotes
		$url = str_replace('\"','',$url);
		//Replace non-alpha chars with '-'
		$match = '/[^a-z0-9]+/';
		$replace = '-';
		$url = preg_replace($match, $replace, $url);
		$url = trim($url, '-');
		return $url;
	}
}
?>