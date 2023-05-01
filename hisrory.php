<?php
require_once("../php/session.php");
require_once("../php/models/app.php");
//
MyApp::setActive("history");

// Cities
require_once("../php/tables/city.php");
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
    if ($i === false) return null;
    return $myCities[$i];
}

// Flights
$showFlights = false;
$myFlights = [];
if (isset($_POST['findFlight'])) {
    require_once("../php/tables/flight.php");
    $res = Flight::findFlight(@$_POST['from_city'], @$_POST['to_city'], @$_POST['departure_date'], @$_post['arrivel_date']);
    if ($res->error) {
        $_GET['error'] = $res->error_msg;
        Navigation::go();
    } else {
        $showFlights = true;
        $myFlights = $res->data;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap-5.2.0-beta1-dist/css/bootstrap.css">
    <script src="../assets/plugins/popper-2.11.5-dist/popper.js"></script>
    <script src="../assets/plugins/bootstrap-5.2.0-beta1-dist/js/bootstrap.js"></script>
    <!-- fontawesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free-6.1.1-web/css/all.css">
</head>

<body>
    <?php include_once("layout/messaging.php"); ?>

    <!-- Start Header -->
    <?php include_once("layout/header.php"); ?>
    <!-- End Header -->
    </form>
    <hr>
    <div class="bg-light p-3 <?= $showFlights ?>">
        <p>Results: <?= count($myFlights) ?></p>
        <hr>
        <?php foreach ($myFlights as $i => $flight) {
            $flight["from_city"] = getCity($flight["from_city_id"]);
            $flight["to_city"] = getCity($flight["to_city_id"]);
        ?>
            <div class="bg-white border rounded shadow p-4 my-3 overflow-hidden">
                <div class="row justify-content-stretch align-content-stretch justify-items-stretch align-items-stretch">
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0 h-100">
                        <div class="row">
                            <div class="d-flex col-12 mb-3">
                                <span><i class="fa-regular fa-building"></i> Airline: <?= @$flight['company_name'] ?></span>
                                <div class="px-2"></div>
                                <span><i class="fa-solid fa-plane-up"></i> Plane: <?= @$flight['airplane_model'] ?></span>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="d-flex m-0 align-content-center align-items-center">
                                    <h2 class="m-0">
                                        <i class="fa-solid fa-plane-departure"></i>
                                    </h2>
                                    <div class="px-2"></div>
                                    <div>
                                        <p class="m-0"><?= @date("H:mA, Y-m-d", @strtotime(@$flight['departure_date'])) ?></p>
                                        <small><?= @$flight['from_airport_name'] ?></small>
                                    </div>
                                    <div class="px-4"></div>
                                    <div>
                                        <p class="m-0"><?= @$flight['from_city']['city_name'] ?>,</p>
                                        <p class="m-0"><?= @$flight['from_city']['country_name'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3 mb-md-0">
                                <div class="d-flex m-0 align-content-center align-items-center">
                                    <h2 class="m-0">
                                        <i class="fa-solid fa-plane-arrival"></i>
                                    </h2>
                                    <div class="px-2"></div>
                                    <div>
                                        <p class="m-0"><?= @date("H:mA, Y-m-d", @strtotime(@$flight['arrival_date'])) ?></p>
                                        <small><?= @$flight['to_airport_name'] ?></small>
                                    </div>
                                    <div class="px-4"></div>
                                    <div>
                                        <p class="m-0"><?= @$flight['to_city']['city_name'] ?>,</p>
                                        <p class="m-0"><?= @$flight['to_city']['country_name'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    </div>
    <!-- End flight search -->


</body>

</html>