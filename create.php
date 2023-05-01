<?php
require_once("../php/session.php");
require_once("../php/models/admin.php");
// check if not logged in
if (MyAdmin::isGuest()) Navigation::go("login");
// set active
MyAdmin::setActive("home");
require_once("../php/tables/flight.php");
require_once("../php/tables/passenger.php");
require_once("../php/tables/city.php");

// Cities
$myCities = [];
$res = City::getAll();
if ($res->error) {
    $_GET['error'] = $res->error_msg;
    Navigation::go();
} else $myCities = $res->data;
function getCity($id = null)
{
    global $myCities;
    $i = array_search($id, array_column($myCities, "city_id"));
    if ($i == false) return null;
    return $myCities[$i];
}

$myAirport = [];
$res = airport::getAll();
if ($res->error) {
    $_GET['error'] = $res->error_msg;
    Navigation::go();
} else $myCities = $res->data;
function gitAirport($id = null)
{
    global $Airport;
    $i = array_search($id, array_column($Airport, "airport_id"));
    if ($i == false) return null;
    return $Airport[$i];
}

$myFlightcompany = [];
$res = Flight_Company::getAll();
if ($res->error) {
    $_GET['error'] = $res->error_msg;
    Navigation::go();
} else $myFlightcompany = $res->data;
function flightcomany($c_name = null)
{
    global $myFlightcompany;
    $i = array_search($c_name, array_column($myFlightcompany, "company_id"));
    if ($i == false) return null;
    return $myFlightcompany[$i];
}

$myairplane = [];
$res = Airplane::getAll();
if ($res->error) {
    $_GET['error'] = $res->error_msg;
    Navigation::go();
} else $myairplane = $res->data;
function airplane($A_model = null)
{
    global $myairplane;
    $i = array_search($A_model, array_column($myairplane, "airplane_id"));
    if ($i == false) return null;
    return $myairplane[$i];
}

$showFlights = false;
$myFlights = [];
if (isset($_POST['addflight'])) {
    $res = Flight::addflight(@$_POST['flight_status'], @$_POST['first_class_price'], @$_POST['economy_class_price'], @$_POST['company_id']);
    if ($res->error) {
        $_GET['error'] = $res->error_msg;
        Navigation::go();
    } else {
        Navigation::go("create");
    }
    Navigation::go();
}


?>

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


    <div class="position-fixed w-100 h-100 d-flex bg-light overflow-auto p-4">
        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 bg-wight border rounded shadow m-auto p-4">
            <form action="createairplane" method="POST" class="form-group mb-3">
                <div class="form-group mb-3">
                    <button type="submit" name="createairplane" class="btn btn-primary w-100">Add Airplane</button>
                </div>
            </form>
            <form action="createflightcompany" method="POST" class="form-group mb-3">
                <div class="form-group mb-3">
                    <button type="submit" name="createairplane" class="btn btn-primary w-100">Add Flight Company</button>
                </div>
            </form>

            <h3>Add Flight</h3>
            <hr>
            <form method="post">
                <div class="form-group mb-3 col-12 col-md-6 mb-3">
                    <label>Flight Status:</label>
                    <select name="flight_status" class="form-control">
                        <option value="new">New</option>
                        <?php foreach ($myFlights as $i => $flightstatus) {
                            echo "<option value='" . $flightstatus['flight_status'] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group mb-3 col-12 col-md-6 mb-3">
                    <label>Flight Company:</label>
                    <select name="flight_company" class="form-control">
                        <option value="">None</option>
                        <?php foreach ($myFlightcompany as $i => $comp_name) {
                            echo "<option value='" . $comp_name['company_id'] . "'>" . $comp_name['company_name'] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group mb-3 col-12 col-md-6 mb-3">
                    <label>Airplane:</label>
                    <select name="airplane" class="form-control">
                        <option value="">None</option>
                        <?php foreach ($myairplane as $i => $A_name) {
                            echo "<option value='" . $A_name['airplane_id'] . "'>" . $A_name['airplane_name'] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <i class="fa-solid fa-plane-departure"></i>
                    <lable> Departure from:</lable>
                    <select name="departure_from" class="form-control">
                        <option value="">None</option>
                        <option value="">
                            <?php foreach ($myAirport as $i => $airport_name) {
                                echo "<option value='" . $airport_name['airport_id'] . "'>" . $airport_name['airport_name'] . ", " . $airport_name['city_name'] . "</option>";
                            } ?>
                        </option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <i class="fa-solid fa-plane-arrival"></i>
                    <lable>Arrival at:</lable>
                    <select name="arrival at" class="form-control">
                        <option value="">None</option>
                        <option value="">
                            <?php foreach ($myAirport as $i => $airport_name) {
                                echo "<option value='" . $airport_name['airport_id'] . "'>" . $airport_name['airport_name'] . ", " . $airport_name['city_name'] . "</option>";
                            } ?>
                        </option>
                    </select>
                </div>
                <div class="form-group mb-3 col-12 col-lg-6">
                    <label>From City:</label>
                    <select name="from_city" class="form-control">
                        <option value="">None</option>
                        <?php foreach ($myCities as $i => $city) {
                            echo "<option value='" . $city['city_id'] . "'>" . $city['city_name'] . ", " . $city['country_name'] . "</option>";
                        } ?>
                    </select>

                </div>
                <div class="form-group mb-3 col-12 col-lg-6">
                    <label>To City:</label>
                    <select name="to_city" class="form-control">
                        <option value="">None</option>
                        <?php foreach ($myCities as $i => $city) {
                            echo "<option value='" . $city['city_id'] . "'>" . $city['city_name'] . ", " . $city['country_name'] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group mb-3 col-12 col-md-6 mb-3 ">
                    <label>Economy Price:</label>
                    <input type="number" name="econpmy_price" class="form-control" placeholder="Enter Economy Price" required>
                </div>
                <div class="form-group mb-3 col-12 col-md-6 mb-3">
                    <label>Frist Class Price:</label>
                    <input type="text" name="first_class_price" class="form-control" placeholder="Frist Class Price" required>
                </div>
                <form action="" method="POST" class="form-group mb-3">
                    <div class="form-group mb-3">
                        <button type="submit" name="add_flight" class="btn btn-primary w-100">Add Flight</button>
                    </div>
                </form>
            </form>
        </div>
    </div>

</body>

</html>