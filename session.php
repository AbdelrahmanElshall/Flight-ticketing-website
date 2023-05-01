<?php
session_start();

// result
class Res
{
    public ?string $error_msg = null;
    public bool $error = false;
    public $data = null;
    public function __construct($error_msg = null, $data = null)
    {
        $this->error_msg = $error_msg;
        $this->error = !empty($error_msg);
        $this->data = $data;
    }

    static function exit($x)
    {
        echo print_r($x, true);
        exit();
    }
}

// navigation
class Navigation
{
    static function go(string $page = "")
    {
        // url params
        $params = "";
        if (!empty($_GET)) {
            foreach ($_GET as $key => $val) {
                if ($val != null) {
                    if (!empty($params)) $params .= "&";
                    $params .= $key . "=" . urlencode($val);
                }
            }
        }
        if (!empty($params)) $params = "?$params";
        // page
        if (empty($page)) $page = basename($_SERVER["PHP_SELF"], '.php');
        // location
        $location = $page . $params;
        if (!empty($location)) header("Location: $location");
        exit();
    }
}
