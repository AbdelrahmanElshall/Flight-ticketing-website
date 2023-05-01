<?php

// Success
if (isset($_POST['clear_success'])) {
    $_GET['success'] = null;
    Navigation::go();
}
if (isset($_GET['success']) && !empty($_GET['success'])) {
?>
    <div class="position-fixed w-100 h-100 d-flex bg-light overflow-auto p-4" style="z-index:999;">
        <form method="post" class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 bg-white border rounded shadow m-auto p-4 border-success">
            <div class="mb-3 d-flex justify-content-stretch align-content-stretch justify-items-center align-items-center">
                <h1 class="text-success">
                    <i class="fa-solid fa-circle-check"></i>
                </h1>
                <div class="px-2"></div>
                <div class="col">
                    <?= @urldecode(@$_GET['success']); ?>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="clear_success" class="btn btn-primary w-100">ok</button>
            </div>
        </form>
    </div>
<?php
}

// alerts
if (isset($_POST['clear_alert'])) {
    $_GET['alert'] = null;
    Navigation::go();
}
if (isset($_GET['alert']) && !empty($_GET['alert'])) {
?>
    <div class="position-fixed w-100 h-100 d-flex bg-light overflow-auto p-4" style="z-index:999;">
        <form method="post" class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 bg-white border rounded shadow m-auto p-4 border-info">
            <div class="mb-3 d-flex justify-content-stretch align-content-stretch justify-items-center align-items-center">
                <h1 class="text-info">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </h1>
                <div class="px-2"></div>
                <div class="col">
                    <?= @urldecode(@$_GET['alert']); ?>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="clear_alert" class="btn btn-primary w-100">ok</button>
            </div>
        </form>
    </div>
<?php
}

// errors
if (isset($_POST['clear_error'])) {
    $_GET['error'] = null;
    Navigation::go();
}
if (isset($_GET['error']) && !empty($_GET['error'])) {
?>
    <div class="position-fixed w-100 h-100 d-flex bg-light overflow-auto p-4" style="z-index:999;">
        <form method="post" class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 bg-white border rounded shadow m-auto p-4 border-danger">
            <div class="mb-3 d-flex justify-content-stretch align-content-stretch justify-items-center align-items-center">
                <h1 class="text-danger">
                    <i class="fa-solid fa-circle-xmark"></i>
                </h1>
                <div class="px-2"></div>
                <div class="col">
                    <?= @urldecode(@$_GET['error']); ?>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="clear_error" class="btn btn-primary w-100">ok</button>
            </div>
        </form>
    </div>
<?php
}
