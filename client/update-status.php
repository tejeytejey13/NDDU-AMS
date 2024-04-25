<?php
session_start();
include '../server/config.php';

if(isset($_SESSION['rfidUID'])){
    $uid = $_SESSION['rfidUID'];
    $updateUidQuery = "UPDATE uid SET active = '2' WHERE user_id = '$uid'";
    $conn->query($updateUidQuery);

}
?>