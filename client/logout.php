<?php
session_start();
include '../server/config.php';

if(isset($_SESSION['rfidUID'])){
    $uid = $_SESSION['rfidUID'];

    // Update the uid active status to '2'
    $updateUidQuery = "UPDATE uid SET active = '2' WHERE user_id = '$uid'";
    $conn->query($updateUidQuery);

    // Destroy the session
    session_unset();
    session_destroy();

    header('Location: ../index.php');
    exit();
} else {
    header('Location: ../index.php');
    exit();
}
?>
