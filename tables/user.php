<?php
require_once(__DIR__ . "/../session.php");
require_once(__DIR__ . "/../database.php");

class user
{
    // for admin
    static function login(string $code = null, string $password = null): Res
    {
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT * FROM user WHERE user_code=:code", ["code" => $code]);
        if ($res->error) return $res;
        if (empty($res->data)) return new Res("User Doesnt Exists!");
        $user = $res->data[0];

        // compare password
        if (@$user['user_password'] !== $password) return new Res("Incorrect Password!");

        return new Res(null, $user);
    }
}
