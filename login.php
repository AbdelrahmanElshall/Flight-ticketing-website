<?php
require_once("../php/session.php");
require_once("../php/models/admin.php");
// check if logged in
if (!MyAdmin::isGuest()) Navigation::go("home");
// login user
if (isset($_POST['login'])) {
    require_once("../php/tables/user.php");
    $res = User::login(@$_POST['code'], @$_POST['password']);
    if ($res->error) $_GET['error'] = $res->error_msg;
    else {
        $pessenger = $res->data;
        $_SESSION['AID'] = @$pessenger['user_id']; // passenger id
        $_SESSION['ADATA'] = json_encode(@$pessengerm); // passenger data
        if (empty(@$_GET['page'])) Navigation::go("home");
        else {
            $page = $_GET['page'];
            $_GET['page'] = null;
            Navigation::go($page);
        }
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
    <title>Login - Admin</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap-5.2.0-beta1-dist/css/bootstrap.css">
    <script src="../assets/plugins/popper-2.11.5-dist/popper.js"></script>
    <script src="../assets/plugins/bootstrap-5.2.0-beta1-dist/js/bootstrap.js"></script>
    <!-- fontawesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free-6.1.1-web/css/all.css">
</head>

<body>
    <?php include_once("layout/messaging.php"); ?>

    <div class="position-fixed w-100 h-100 d-flex bg-light overflow-auto p-4">

        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 bg-white border rounded shadow m-auto p-4">
            <h3>Login</h3>
            <hr>
            <form method="post">
                <div class="form-group mb-3">
                    <label>User Code:</label>
                    <input type="text" name="code" class="form-control" placeholder="Enter code" min="6" max="301" required>
                </div>
                <div class="form-group mb-3">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" min="6" max="25" required>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" name="login" class="btn btn-primary w-100">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Login</button>
                </div>
                <div class="form-group mb-3">
                    <a class="text-danger" href="../app/">Cancel</a>
                </div>
            </form>
        </div>

    </div>
</body>

</html>