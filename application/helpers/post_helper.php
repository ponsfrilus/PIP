<?php

class Post_helper
{
    public function get($key)
    {
        return $_POST["$key"];
    }

    public function has($key)
    {
        return isset($_POST["$key"]);
    }

    public function hasValue($key)
    {
        return isset($_POST["$key"]) && !is_null($_POST["$key"]);
    }

    public function hasStringValue($key)
    {
        return $this->hasValue($key) && strlen($this->get($key)) > 0;
    }
}

?>