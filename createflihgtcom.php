<?php
require_once("../php/tables/flight.php");
require_once("../php/tables/passenger.php");

require_once("../php/session.php");
require_once("../php/models/admin.php");
// check if not logged in
if (MyAdmin::isGuest()) Navigation::go("login");
// set active
MyAdmin::setActive("home");
require_once("../php/tables/flight.php");
require_once("../php/tables/passenger.php");
require_once("../php/tables/city.php");

if (isset($_POST['flight_company'])) {

    $res = Flight_Company::addflightcompany(@$_POST['company_name']);
    if ($res->error) $_GET['error'] = $res->error_msg;
    else {
        Navigation::go("create");
    }
    Navigation::go();
}
?>
<?php include("partial/header.php") ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap-5.2.0-beta1-dist/css/bootstrap.css">
    <script src="../assets/plugins/popper-2.11.5-dist/popper.js"></script>
    <script src="../assets/plugins/bootstrap-5.2.0-beta1-dist/js/bootstrap.js"></script>
    <!-- fontawesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free-6.1.1-web/css/all.css">
</head>

<body>

    <?php include("layout/header.php") ?>
    <?php include("layout/messaging.php") ?>



<?php include("partial/footer.php") ?>