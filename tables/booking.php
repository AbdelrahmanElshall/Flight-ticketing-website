<?php
require_once(__DIR__ . "/../session.php");
require_once(__DIR__ . "/../database.php");

class booking
{
    static string $table = "booking";

    static function showbooking( string $flight_id = null,string $passenger_id = null): Res
    {
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT * FROM " . booking::$table . " WHERE flight_id=:flight_id And passenger_id=:passenger_id", ["flight_id" => $flight_id,"passenger_id"=>$passenger_id]);
        if ($res->error) return $res;
        if (!empty($res->data)) return new Res("No Flights Booking");

        return new Res();
    }
}

// no need for this page only for admin i think
