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
        // $schedulefrom = $_POST['schedulefrom'];
        // $scheduleto = $_POST['scheduleto'];
        // $password = $_POST['password'];

        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
       
        
        $select = "SELECT * FROM users WHERE rfidUID = '$uid'";
        $query = $conn->query($select);

        if($query->num_rows > 0){
            $inser = "INSERT INTO users (rfidUID, firstname, middlename, lastname, subjectCode, subjectDescription, role, status) 
            VALUES ('$uid','$firstname', '$middlename', '$lastname', '$subjectcode', '$subjectdescription', 'student', 'registered')";

            $updateSqlUID = "UPDATE uid SET
                active= '3'
                WHERE user_id = '$uid'";

            if($conn->query($inser) === TRUE && $conn->query($updateSqlUID) === TRUE){
                $response['success'] = true;
                $response['message'] = 'UID recorded.';
            } else {
                $response['message'] = 'Error inserting attendance: ' . $conn->error;
            }

            

        } else {
            $inser = "INSERT INTO users (rfidUID, firstname, middlename, lastname, subjectCode, subjectDescription, role, status) 
            VALUES ('$uid','$firstname', '$middlename', '$lastname', '$subjectcode', '$subjectdescription', 'student', 'registered')";

            $updateSqlUID = "UPDATE uid SET
                active= '3'
                WHERE user_id = '$uid'";

            if($conn->query($inser) === TRUE && $conn->query($updateSqlUID) === TRUE){
                $response['success'] = true;
                $response['message'] = 'UID recorded.';
            } else {
                $response['message'] = 'Error inserting attendance: ' . $conn->error;
            }
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