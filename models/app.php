<?php
include_once(__DIR__ . "/../session.php");

class MyApp
{
    // page active
    static string $active = "";
    static function setActive(string $page)
    {
        MyApp::$active = $page;
    }
    static function getActive(string $page): string
    {
        return  MyApp::$active == $page ? "text-primary active" : "";
    }
    // passenger
    static function isGuest(): bool
    {
        return empty(@$_SESSION['PID']);
    }
    static function getId(): string
    {
        return @$_SESSION['PID'];
    }
    static function getName(): string
    {
        return @json_decode(@$_SESSION['PDATA'], true)['name'];
    }
}
