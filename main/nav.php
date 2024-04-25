<?php
session_start();

if (!isset($_SESSION['rfidUID'])) {
    header('Location: ../index.php');
}

if (
    isset($_SESSION['rfidUID'])
    && isset($_SESSION['subjectCode'])
    && isset($_SESSION['scheduleFrom'])
    && isset($_SESSION['scheduleTo'])
    && isset($_SESSION['firstname'])
    && isset($_SESSION['middlename'])
    && isset($_SESSION['lastname'])
    && isset($_SESSION['suffix'])
) {
    $uid = $_SESSION['rfidUID'];
    $subject = $_SESSION['subjectCode'];
    $scheduleFrom = $_SESSION['scheduleFrom'];
    $scheduleTo = $_SESSION['scheduleTo'];
    $fname = $_SESSION['firstname'];
    $mname = $_SESSION['middlename'];
    $lname = $_SESSION['lastname'];
    $suffix = $_SESSION['suffix'];
}
?>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="#"><img src="../images/nddu/nddulogo.png" class="mr-2" alt="logo" /><span style="color:  #1a6431; font-weight: 700">NDDU AMS</span></a>
        <a class="navbar-brand brand-logo-mini" href="#"><img src="../images/nddu/nddulogo.png" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">

            </li>
            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="../client/logout.php" style="color:red; font-weight: 900;">
                    LOG OUT
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
<script src="../client/js/close.js?ver=1.1"></script>