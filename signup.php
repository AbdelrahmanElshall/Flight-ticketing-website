<?php
require_once("../php/session.php");
require_once("../php/models/app.php");
// check if logged in
if (!MyApp::isGuest()) Navigation::go("home");
// signup user
if (isset($_POST['signup'])) {
    require_once("../php/tables/passenger.php");
    $res = Passenger::signup(@$_POST['name'], @$_POST['ssn'], @$_POST['phone'], @$_POST['email'], @$_POST['password'], @$_POST['gender'], @$_POST['brithdate']);
    if ($res->error) $_GET['error'] = $res->error_msg;
    else {
        $_GET['alert'] = "Signup Successfull, Please login to continue.";
        Navigation::go("login");
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
    <title>Signup</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap-5.2.0-beta1-dist/css/bootstrap.css">
    <script src="../assets/plugins/popper-2.11.5-dist/popper.js"></script>
    <script src="../assets/plugins/bootstrap-5.2.0-beta1-dist/js/bootstrap.js"></script>
    <!-- fontawesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free-6.1.1-web/css/all.css">
</head>

<body>
    <?php include_once("../app/layout/messaging.php"); ?>

    <div class="position-fixed w-100 h-100 d-flex bg-light overflow-auto p-4">

        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 bg-white border rounded shadow m-auto p-4">
            <h3>Signup</h3>
            <hr>
            <form method="post">
                <div class="form-group mb-3">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                </div>
                <div class="form-group mb-3">
                    <label>Email address:</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" min="6" max="301" required>
                </div>
                <div class="form-group mb-3">
                    <label>SSN:</label>
                    <input type="number" name="ssn" class="form-control" placeholder="Enter SSN" min="20000000000000" max="29999999999999" required>
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
                    <label>gender:</label>
                    <select name="gender" class="form-control">
                        <option value="">None</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Birth Date:</label>
                    <input type="date" name="birthdate" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" name="signup" class="btn btn-primary w-100">
                        <i class="fa-solid fa-user-plus"></i> Create Account</button>
                </div>

                <div class="form-group mb-3">
                    <a href="login">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Already have an account?</a>
                </div>

                <div class="form-group mb-3">
                    <a class="text-danger" href="home">Cancel</a>
                </div>
            </form>
        </div>

    </div>

</body>

</html>