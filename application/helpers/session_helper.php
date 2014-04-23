<?php

class Session_helper {

	function set($key, $val)
	{
		$_SESSION["$key"] = $val;
	}
	
	function get($key)
	{
		return $_SESSION["$key"];
	}
	
	function has($key)
	{
		return isset($_SESSION["$key"]);
	}

	function clear($key)
	{
		unset($_SESSION["$key"]);
	}

	function destroy()
	{
		session_destroy();
	}

}

?>