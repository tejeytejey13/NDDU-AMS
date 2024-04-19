<?php
session_start();
include 'config.php';
header('Content-Type: application/json');
$postData = file_get_contents("php://input");
$jsonData = json_decode($postData, true);

$response = array('success' => false, 'message' => '');


if (isset($jsonData['uid'])) {
    $uid = $jsonData['uid'];

    $selectUID = "SELECT * FROM uid WHERE user_id = '$uid' AND active = '1' ";
    $checkkUID = $conn->query($selectUID);

    if($checkkUID->num_rows > 0){
        $response = array('success' => false, 'message' => 'UID already registered.');

    } else {
        $insertSql1 = "INSERT INTO uid (user_id, active) VALUES ('$uid', '0')";

        if($conn->query($insertSql1) === TRUE){
            $response['success'] = true;
            $response['message'] = 'UID recorded.';
        } else {
            $response['message'] = 'Error inserting attendance: ' . $conn->error;
        }
    
    }

   
    $checkSql = "SELECT * FROM users WHERE rfidUID = '$uid'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        $response = array('success' => false, 'message' => 'UID already registered.');
    } else {
        $insertSql = "INSERT INTO users (rfidUID) VALUES ('$uid')";

        if ($conn->query($insertSql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'UID recorded.';
        } else {
            $response['message'] = 'Error inserting attendance: ' . $conn->error;
        }
    }

    $conn->close();
} else {
    $response = array('success' => false, 'message' => 'UID not found in POST data.');
}
echo json_encode($response);
?>