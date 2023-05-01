<?php
include_once(__DIR__ . "/../session.php");

class MyAdmin
{
    // page active
    static string $active = "";
    static function setActive(string $page)
    {
        MyAdmin::$active = $page;
    }
    static function getActive(string $page): string
    {
        return  MyAdmin::$active == $page ? "text-primary active" : "";
    }
    // passenger
    static function isGuest(): bool
    {
        return empty(@$_SESSION['AID']);
    }
    static function getId(): string
    {
        return @$_SESSION['AID'];
    }
    static function getName(): string
    {
        return @json_decode(@$_SESSION['ADATA'], true)['name'];
    }
}
