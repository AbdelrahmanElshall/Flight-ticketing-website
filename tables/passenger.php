<?php
require_once(__DIR__ . "/../session.php");
require_once(__DIR__ . "/../database.php");

class Passenger
{
    //for passenger
    static function login(string $email = null, string $password = null, string $ssn=null): Res
    {
        // proccess data
        $email = strtolower($email);

        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT * FROM passenger WHERE passenger_email=:email", ["email" => $email ]);
        if ($res->error) return $res;
        if (empty($res->data)) return new Res("User Doesnt Exists!");
        $passenger = $res->data[0];

        // compare password
        if (@$passenger['passenger_password'] !== $password) return new Res("Incorrect Password!");

        return new Res(null, $passenger);
    }
    //
    static function signup(string $name = null, string $ssn = null, string $phone = null, string $email = null, string $password = null, string $gender = null, string $birthdate = null): Res
    {
        // proccess data
        $email = strtolower($email);

        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT * FROM passenger WHERE passenger_email=:email And passenger_ssn=:ssn", ["email" => $email , "ssn"=>$ssn]);
        if ($res->error) return $res;
        if (!empty($res->data)) return new Res("User Already Exists");

        // add user to database
        $res = Database::excute(
            "INSERT INTO passenger (passenger_name,passenger_ssn,passenger_phone,passenger_email,passenger_password,passenger_gender,passenger_birthdate) VALUES (:name,:ssn,:phone,:email,:password,:gender,:birthdate)",
            ["name" => $name, "ssn" => $ssn, "phone" => $phone, "email" => $email, "password" => $password, "gender" => $gender, "birthdate" => $birthdate]
        );
        if ($res->error) return $res;

        return new Res();
    }
    //
    static function getBooking(string $passenger_id = null, string $flight_id = null)
    {
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // check if user already exists
        $res = Database::excute("SELECT * FROM booking WHERE passenger_id=:passenger_id AND flight_id=:flight_id", ["passenger_id" => $passenger_id, "flight_id" => $flight_id]);
        if ($res->error) return $res;
        //
        return new Res(null, $res->data);
    }
    //
    static function bookFlight(string $passenger_id = null, string $flight_id = null, string $flight_seats = null, string $flight_class = null)
    {
        // connect with database        
        $res = Database::connect();
        if ($res->error) return $res;

        // add booking to database
        $res = Database::excute(
            "INSERT INTO booking (passenger_id,flight_id,flight_seats,booking_class)
             VALUES (:passenger_id,:flight_id,:flight_seats,:flight_class)",
            ["passenger_id" => $passenger_id, "flight_id" => $flight_id, "flight_seats" => $flight_seats, "flight_class" => $flight_class]
        );
        if ($res->error) return $res;

        return new Res();
    }


    // for admin
}
