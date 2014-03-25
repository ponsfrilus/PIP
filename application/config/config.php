<?php 

$config['base_url'] = ''; // Base URL including trailing slash (e.g. http://localhost/)

$config['default_controller'] = 'main'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)

/*
Define pre_route_handler to call a function before routing takes places. This can be used
to, for example, check for user logins and redirect to a login page if the user is not
currently logged in.

function someFunc()
{
	return array('controller' => 'error', 'action' => 'index');
}
$config['pre_route_handler'] = 'someFunc';
*/

$config['db_host'] = ''; // Database host (e.g. localhost)
$config['db_name'] = ''; // Database name
$config['db_username'] = ''; // Database username
$config['db_password'] = ''; // Database password

?>