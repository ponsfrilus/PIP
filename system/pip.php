<?php

function loadController($controller)
{
    $path = APP_DIR . 'controllers/' . $controller . '.php';
    require_once($path);
}

function controllerExists($controller)
{
    $path = APP_DIR . 'controllers/' . $controller . '.php';
    return file_exists($path);
}

function pip()
{
    global $config;

    if (isset($config['pre_route_handler']) && is_string($config['pre_route_handler']))
    {
        $override = call_user_func($config['pre_route_handler']);
    }

    $segments = array();

    if (isset($override) && isset($override['controller']) && isset($override['action']))
    {
        $controller = $override['controller'];
        $action = $override['action'];
    }
    else
    {
        // Set our defaults
        $controller = $config['default_controller'];
        $action = 'index';
        $url = '';
        
        // Get request url and script url
        $request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
            
        // Get our url path and trim the / of the left and the right
        if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
        
        // Split the url into segments
        $segments = explode('/', $url);
        
        // Do our default checks
        $hasAction = false;
        if(isset($segments[0]) && $segments[0] != '') $controller = $segments[0];
        if(isset($segments[1]) && $segments[1] != '') {
            $action = $segments[1];
            $hasAction = true;
        }
    }

    if (controllerExists($controller)) {
        loadController($controller);
    } else if (!$hasAction) {
        // Controller file doesn't exist and no action was specified, so
        // maybe the controller is really an action on the default controller.
        $action = $controller;
        $controller = $config['default_controller'];
        loadController($controller);
    } else {
        $controller = $config['error_controller'];
        loadController($controller);
    }

    // Check the action exists
    if(!method_exists($controller, $action)){
        $controller = $config['error_controller'];
        loadController($controller);
        $action = 'index';
    }

    // Create object and call method
    $obj = new $controller;
    die(call_user_func_array(array($obj, $action), array_slice($segments, 2)));
}

?>
