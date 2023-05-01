<?php
require_once("session.php");
//
class Database
{
    static string $host = "localhost";
    static string $name = "booking";
    static string $user = "root";
    static string $pass = "";
    static ?PDO $conn = null;

    static function connect(): Res
    {
        try {
            Database::$conn = new PDO("mysql:host=" . Database::$host . ";dbname=" . Database::$name, Database::$user, Database::$pass);
            Database::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new Res();
        } catch (PDOException $e) {
            return new Res("database_connection_faild: {$e}");
        }
    }

    static function excute(string $query, array $arguments = null): Res
    {
        try {
            $stmt = Database::$conn->prepare($query);
            if (!empty($arguments)) {
                foreach ($arguments as $key => $value) {
                    $stmt->bindValue(":{$key}", $value);
                }
            }
            $stmt->execute();
            return new Res(null, $stmt->fetchall(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return new Res("query_failed: {$e}");
        }
    }
    static function disconnect(string $email, string $password): Res
    {
        $res = Database::connect();
        if ($res->error) Res::exit($res->error_msg);

        $res = Database::excute("select * from passenger where passenger_email=:email AND passenger_password=:password", ["email" => $email , "password"=> $password]);
        if ($res->error) Res::exit($res->error_msg);
        $data = $res->data;

        Res::exit($data);
    }
}


/*
$res = Database::connect();
if ($res->error) Res::exit($res->error_msg);

$res = Database::excute("select * from passenger where passenger_email=:email", ["email" => "moemenzaafarany@gmail.com"]);
if ($res->error) Res::exit($res->error_msg);
$data = $res->data;

Res::exit($data);
*/