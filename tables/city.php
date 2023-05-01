<?php
require_once(__DIR__ . "/../session.php");
require_once(__DIR__ . "/../database.php");

class City
{
    static string $table = "city";
    static string $table2 = "country";

    //for passenger
    static function getAll(): Res
    {
        // get all cities and countries in cities 
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT ct.*, cu.* FROM city ct LEFT JOIN country cu ON cu.country_id=ct.country_id WHERE 1");
        if ($res->error) return $res;

        return new Res(null, $res->data);
    }

    // for admin
}
