<?php
include '../server/config.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if 'uid' key is set in the POST data
    if (isset($_POST['uid'])) {
        $uid = $_POST['uid'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $subjectcode = $_POST['subjectcode'];
        $subjectdescription = $_POST['subjectdescription'];
        $schedulefrom = $_POST['schedulefrom'];
        $scheduleto = $_POST['scheduleto'];
        $password = $_POST['password'];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $updateSql = "UPDATE users SET
            firstname = '$firstname',
            middlename = '$middlename',
            lastname = '$lastname',
            subjectCode = '$subjectcode',
            subjectDescription = '$subjectdescription',
            scheduleFrom = '$schedulefrom',
            scheduleTo = '$scheduleto',
            role = 'professor',
            status = 'registered',
            password = '$hashedPassword'
            WHERE rfidUID = '$uid'";

        if ($conn->query($updateSql) === TRUE) {
            $response = array('success' => true, 'message' => 'Data updated successfully.');
        } else {
            $response = array('success' => false, 'message' => 'Error updating data: ' . $conn->error);
        }

        $conn->close();
    } else {
        $response = array('success' => false, 'message' => 'Invalid POST data: "uid" key is not set.');
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request method.');
}

echo json_encode($response);
?>
