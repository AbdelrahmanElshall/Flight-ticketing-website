<?php

require_once(__DIR__ . "/../session.php");
require_once(__DIR__ . "/../database.php");

class Flight
{
    static string $table = "flight";

    // for passenger
    static function findFlight(string $from_city = null, string $to_city = null, string $departure_date = null, string $arrival_date = null): Res
    {
        // get all cities and countries in cities 
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // build query
        $args = [];
        $query = "1";
        //
        if (!empty($from_city)) {
            if (!empty($query)) $query .= " AND ";
            $query .= "fap.city_id=:from_city";
            $args['from_city'] = $from_city;
        }
        //
        if (!empty($to_city)) {
            if (!empty($query)) $query .= " AND ";
            $query .= "tap.city_id=:to_city";
            $args['to_city'] = $to_city;
        }
        //
        if (!empty($departure_date)) {
            if (!empty($query)) $query .= " AND ";
            $query .= "DATE_FORMAT(f.departure_date, '%Y-%m-%d')=:departure_date";
            $args['departure_date'] = $departure_date;
        }
        //
        if (!empty($arrival_date)) {
            if (!empty($query)) $query .= " AND ";
            $query .= "DATE_FORMAT(f.arrival_date, '%Y-%m-%d')=:arrival_date";
            $args['arrival_date'] = $arrival_date;
        }
        //
        // check if user already exists
        $res = Database::excute(
            "SELECT f.*,
            fap.airport_name as from_airport_name,
            fap.city_id as from_city_id,
            tap.airport_name as to_airport_name,
            tap.city_id as to_city_id,
             a.num_of_first_seat,
             a.num_of_eco_seat,
             a.airplane_model,
             fc.company_name
             FROM flight f
            LEFT JOIN airport fap ON fap.airport_id=f.from_airport_id
            LEFT JOIN airport tap ON tap.airport_id=f.to_airport_id
            LEFT JOIN airplane a ON a.airplane_id=f.airplane_id
            LEFT JOIN flight_company fc ON fc.company_id=a.company_id
            WHERE f.flight_status='new' AND $query",
            $args
        );
        if ($res->error) return $res;

        return new Res(null, $res->data);
    }
    static function getById(string $flight_id = null): Res
    {
        // get all cities and countries in cities 
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute(
            "SELECT f.*,
            fap.airport_name as from_airport_name,
            fct.city_id as from_city_id,
            fct.city_name as from_city_name,
            fcy.country_id as from_country_id,
            fcy.country_name as from_country_name,
            tap.airport_name as to_airport_name,
            tct.city_id as to_city_id,
            tct.city_name as to_city_name,
            tcy.country_id as to_country_id,
            tcy.country_name as to_country_name,
            tap.city_id as to_city_id,
            a.num_of_first_seat,
            a.num_of_eco_seat,
            a.airplane_model,
            fc.company_name,
            Sum(bf.flight_seats) as booked_first_seats,
            SUM(be.flight_seats) as booked_eco_seats
            FROM flight f
            LEFT JOIN airport fap ON fap.airport_id=f.from_airport_id
            LEFT JOIN city fct ON fct.city_id=fap.city_id
            LEFT JOIN country fcy ON fcy.country_id=fct.country_id
            LEFT JOIN airport tap ON tap.airport_id=f.to_airport_id
            LEFT JOIN city tct ON tct.city_id=tap.city_id
            LEFT JOIN country tcy ON tcy.country_id=tct.country_id
            LEFT JOIN airplane a ON a.airplane_id=f.airplane_id
            LEFT JOIN flight_company fc ON fc.company_id=a.company_id
            LEFT JOIN booking be ON be.flight_id=f.flight_id AND be.booking_class='first' AND be.canceled=0
            LEFT JOIN booking bf ON bf.flight_id=f.flight_id AND bf.booking_class='economy' AND bf.canceled=0
            WHERE f.flight_status='new' AND f.flight_id=:flight_id
            Group By f.flight_id",
            ["flight_id" => $flight_id]
        );
        if ($res->error) return $res;
        return new Res(null, $res->data);
    }

    // for admin
    static function addflight(string $flight_status = null, string $first_class_price = null, string $economy_class_price = null, string $trsansient = null, string $departure_date = null, string $arrivel_date = null, string $airplane_id = null, string $from_airport_id = null, string $to_airport_id = null): Res
    {
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT * FROM " . Flight::$table . " WHERE departure_date =< :departure_date AND airplane_id =:airplane_id ", ["departure_date" => $departure_date, "airplane_id" => $airplane_id]);
        if ($res->error) return $res;
        if (!empty($res->data)) return new Res("Flight is Already found");

        // add flight to database
        $res = Database::excute(
            "INSERT INTO " . Flight::$table . " (flight_status,first_class_price,economy_class_price,is_transient,departure_date,arrival_date,airplane_id,from_airport_id,to_airport_id) VALUES (:flight_status,:first_class_price,:economy_class_price,:is_transient,:departure_date,:arrival_date,:airplane_id,:from_airport_id,:to_airport_id)",
            ["flight_status" => $flight_status, "first_class_price" => $first_class_price, "economy_class_price" => $economy_class_price, "trsansient" => $trsansient, "departure_date" => $departure_date, "arrivel_date" => $arrivel_date, "airplane_id" => $airplane_id, "from_airport_id" => $from_airport_id, "to_airport_id" => $to_airport_id]
        );
        return $res;

        return new Res();
    }

    static function deleteflight(string $flight_status = null, string $first_class_price = null, string $economy_class_price = null, string $trsansient = null, string $departure_date = null, string $arrivel_date = null, string $airplane_id = null, string $from_airport_id = null, string $to_airport_id = null): Res
    {
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT * FROM " . Flight::$table . " WHERE departure_date =:departure_date AND airplane_id =:airplane_id ", ["departure_date" => $departure_date, "airplane_id" => $airplane_id]);
        if ($res->error) return $res;
        if (!empty($res->data)) return new Res("No Flight Found");

        // add flight to database
        $res = Database::excute(
            "DELETE FROM " . Flight::$table . " (flight_status,first_class_price,economy_class_price,is_transient,departure_date,arrival_date,airplane_id,from_airport_id,to_airport_id,flight_id)"
        );

        if ($res->error) return $res;

        return new Res();
    }
}
class Airplane
{
    static string $table = "airplane";
    static function addairplane(string $num_of_first_seat = null, string $num_of_eco_seat = null, string $airplane_model = null, string $company_id = null)
    {
        $res = Database::connect();
        if ($res->error) return $res;

        $res = Database::excute("SELECT * FROM " . Airplane::$table . " WHERE airplane_model = :airplane_model", ["airplane_model" => $airplane_model]);
        if ($res->error) return $res;
        if (!empty($res->data)) return new Res("Airplane is Already found");

        $res = Database::excute(
            "INSERT INTO " . Airplane::$table . "(num_of_first_seat,num_of_eco_seat,airplane_model,company_id) VALUES (:num_of_first_seat,:num_of_eco_seat,:airplane_model,:company_id)",
            ["num_of_first_seat" => $num_of_first_seat, "num_of_eco_seat" => $num_of_eco_seat, "airplane_model" => $airplane_model, "company_id" => $company_id]
        );
        if ($res->error) return $res;

        return new Res();
    }
    static function getAll(): Res
    {
        // get all cities and countries in cities 
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT airplane_model FROM airplane WHERE 1");
        if ($res->error) return $res;

        return new Res(null, $res->data);
    }
}

class Flight_Company
{
    static string $table = "flight_company";
    static function addflightcompany(string $company_name = null)
    {
        $res = Database::connect();
        if ($res->error) return $res;

        $res = Database::excute("SELECT * FROM " . Flight_Company::$table . "WHERE company_name = :company_name", ["company_name" => $company_name]);
        if ($res->error) return $res;
        if (!empty($res->data)) return new Res("Flight-Company is Already found");

        $res = Database::excute(
            "INSERT INTO " . Flight_Company::$table . "(:company_id)",
            ["company_name" => $company_name]
        );
        if ($res->error) return $res;

        return new Res();
    }

    //for admin
    static function getAll(): Res
    {
        // get all cities and countries in cities 
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT company_name FROM flight_company WHERE 1");
        if ($res->error) return $res;

        return new Res(null, $res->data);
    }
}

class airport
{
    static string $table = "airport";
    static function addairport(string $airport_name = null)
    {
        $res = Database::connect();
        if ($res->error) return $res;

        $res = Database::excute("SELECT * FROM " . airport::$table . "WHERE airport_name = :airport_name", ["airport_name" => $airport_name]);
        if ($res->error) return $res;
        if (!empty($res->data)) return new Res("Flight-Company is Already found");

        $res = Database::excute(
            "INSERT INTO " . airport::$table . "(:airport_id)",
            ["airport_name" => $airport_name]
        );
        if ($res->error) return $res;

        return new Res();
    }

    //for admin
    static function getAll(): Res
    {
        // get all cities and countries in cities 
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT airport_name FROM airport WHERE 1");
        if ($res->error) return $res;

        return new Res(null, $res->data);
    }
}
