<?php
require_once("../php/session.php");
require_once("../php/models/app.php");
// check if logged in
if (MyApp::isGuest()) {
    $_GET = array_merge($_GET, $_POST);
    $_GET["page"] = "booking";
    Navigation::go("login");
}
// get flight data
if (empty(@$_REQUEST['flight_id']) || empty(@$_REQUEST['flight_class'])) {
    $_GET["error"] = "You can't enter this page!";
    Navigation::go("home");
}
// check 
require_once("../php/tables/passenger.php");
$res = Passenger::getBooking(MyApp::getId(), @$_REQUEST['flight_id']);
if ($res->error) {
    $_GET['error'] = $res->error_msg;
    Navigation::go("home");
} else if (!empty($res->data)) {
    $_GET['error'] = "Flights cannot be booked twice!";
    Navigation::go("home");
}

// Flight
require_once("../php/tables/flight.php");
$myFlight = [];
$res = Flight::getById(@$_REQUEST['flight_id']);
if ($res->error) {
    $_GET['error'] = $res->error_msg;
    Navigation::go("home");
} else if (empty($res->data)) {
    $_GET['error'] = "Flight not available for booking!";
    Navigation::go("home");
} else {
    $myFlight = $res->data[0];
}

// Book Flight
if (isset($_POST['book'])) {
    $res = Passenger::bookFlight(MyApp::getId(), @$_REQUEST['flight_id'], $_REQUEST['flight_seats'], $_REQUEST['flight_class']);
    if ($res->error) $_GET['error'] = $res->error_msg;
    else {
        $_GET['success'] =
            "Flight booked: <br> 
        Departure At <b>" . @date("H:mA, Y-m-d", @strtotime(@$myFlight['departure_date'])) . "</b> From <b>" . @$myFlight['from_city_name'] . ", " . @$myFlight['from_country_name'] . "</b>.<br> 
        Arrival At <b>" . @date("H:mA, Y-m-d", @strtotime(@$myFlight['arrival_date'])) . "</b> To <b>" . @$myFlight['to_city_name'] . ", " . @$myFlight['to_country_name'] . "</b>.<br> <br> 
        <p class='mb-0 text-center'>Have a safe Flight :)</p>";

        Navigation::go("home");
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
    <title>Booking</title>
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

    <!-- Start flight search -->
    <div class="container py-5">
        <h3>Flight Details</h3>
        <hr>
        <div class="bg-white border rounded shadow p-4 my-3 overflow-hidden">
            <div class="row justify-content-stretch align-content-stretch justify-items-stretch align-items-stretch">

                <div class="d-flex col-12 mb-3 justify-content-center">
                    <span class=" text-center"><i class="fa-regular fa-building"></i> Airline: <?= @$myFlight['company_name'] ?></span>
                    <div class="px-4"></div>
                    <span class=" text-center"><i class="fa-solid fa-plane-up"></i> Plane: <?= @$myFlight['airplane_model'] ?></span>
                </div>

                <div class="col-12 mb-3">
                    <div class="d-flex m-0 justify-content-center align-content-center align-items-center">
                        <h2 class="m-0">
                            <i class="fa-solid fa-plane-departure"></i>
                        </h2>
                        <div class="px-4"></div>
                        <div>
                            <p class="m-0"><?= @date("H:mA, Y-m-d", @strtotime(@$myFlight['departure_date'])) ?></p>
                            <small><?= @$myFlight['from_airport_name'] ?></small>
                        </div>
                        <div class="px-4"></div>
                        <div>
                            <p class="m-0"><?= @$myFlight['from_city_name'] ?>,</p>
                            <p class="m-0"><?= @$myFlight['from_country_name'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="d-flex m-0 justify-content-center align-content-center align-items-center">
                        <h2 class="m-0">
                            <i class="fa-solid fa-plane-arrival"></i>
                        </h2>
                        <div class="px-4"></div>
                        <div>
                            <p class="m-0"><?= @date("H:mA, Y-m-d", @strtotime(@$myFlight['arrival_date'])) ?></p>
                            <small><?= @$myFlight['to_airport_name'] ?></small>
                        </div>
                        <div class="px-4"></div>
                        <div>
                            <p class="m-0"><?= @$myFlight['to_city_name'] ?>,</p>
                            <p class="m-0"><?= @$myFlight['to_country_name'] ?></p>
                        </div>
                    </div>
                </div>


                <form class="col-12 mb-3" method="GET">
                    <input type="hidden" name="flight_id" value="<?= @$myFlight['flight_id'] ?>">

                    <div class="text-center">
                        <span><i class="fa-solid fa-ribbon"></i> Class: <b><?= @$_REQUEST['flight_class'] == "first" ? "First Class" : "Economy Class" ?></b></span>
                    </div>
                    <div class="text-center">
                        <?php if (@$_REQUEST['flight_class'] == "first") { ?>
                            <button name="flight_class" value="economy" class="btn btn-outline-primary text-center">
                                Change to Economy for <b><?= @$myFlight['economy_class_price'] ?></b> EGP
                            </button>
                        <?php } else { ?>
                            <button name="flight_class" value="first" class=" btn btn-outline-success text-center">
                                Change to First Class <b><?= @$myFlight['first_class_price'] ?></b> EGP
                            </button>
                        <?php } ?>
                    </div>
                </form>

                <form class="col-12 mb-3" method="post">
                    <div class="d-flex flex-column m-0 justify-content-center align-content-center align-items-center">
                        <input type="hidden" name="flight_id" value="<?= @$myFlight['flight_id'] ?>">
                        <input type="hidden" name="flight_class" value="<?= @$_REQUEST['flight_class'] ?>">

                        <div class="d-inline-block mb-3">
                            <label>Seats:</label>
                            <select name="flight_seats" class="d-inline-block form-control" required>
                                <option value="">None</option>
                                <?php if (@$_REQUEST['flight_class'] == 'first') $count = @$myFlight['num_of_first_seat'] - (@$myFlight['booked_first_seats'] ?: 0);
                                else $count = @$myFlight['num_of_eco_seat'] - (@$myFlight['booked_eco_seats'] ?: 0);
                                for ($i = 1; $i <= $count; $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="text-center">
                            <button name="book" class="btn btn-outline-primary text-center">
                                <i class="fa-solid fa-ticket"></i> Book
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End flight search -->


</body>

</html>