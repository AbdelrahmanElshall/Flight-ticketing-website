<?php
include_once("../php/session.php");
session_destroy();
Navigation::go("login");
