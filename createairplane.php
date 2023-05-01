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
$myFlightcompany = [];
$res = Flight_Company::getAll();
if ($res->error) {
    $_GET['error'] = $res->error_msg;
    Navigation::go();
} else $myFlightcompany = $res->data;
function getCity($id = null)
{
    global $myFlightcompany;
    $i = array_search($id, array_column($myFlightcompany, "company_id"));
    if ($i == false) return null;
    return $myFlightcompany[$i];
}

if (isset($_POST['addairplane'])) {

    $res = Airplane::addairplane(@$_POST['num_of_first_seat'], @$_POST['num_of_eco_seat'], @$_POST['airplane_model']);
    if ($res->error) $_GET['error'] = $res->error_msg;
    else {
        Navigation::go("createairplane");
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
        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 bg-white border rounded shadow m-auto p-4">
            <h3>Add Airplane</h3>
            <hr>
            <form method="post">
                <div class="form-group mb-3">
                    <label>Airplane Model:</label>
                    <input type="text" name="Airplane Model" class="form-control" placeholder="Enter name" required>
                </div>
                <div class="form-group mb-3">
                    <label>No of First Seats:</label>
                    <input type="number" name="num_of_first_seat" class="form-control" placeholder="No of First Seats" required>
                </div>
                <div class="form-group mb-3">
                    <label>No of Economy Seats:</label>
                    <input type="number" name="num_of_eco_seat" class="form-control" placeholder="No of Economy Seats" required>
                </div>
                <div class="form-group mb-3">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" min="6" max="25" required>
                </div>
                <div class="form-group mb-3">
                    <label>Phone Number:</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter Your Phone Number" required>
                </div>
                <div class="form-group mb-3">
                    <label>For Each Company:</label>
                    <select name="" id="">
                        <option value="none">None</option>
                        <option>

                        </option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" name="signup" class="btn btn-primary w-100">Add Airplane</button>
                </div>
            </form>
            < </div>
        </div>
    </div>
    <?php include("partial/footer.php") ?>