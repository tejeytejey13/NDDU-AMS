<?php
include '../server/config.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if required fields are set in the POST data
    if (isset($_POST['uid'], $_POST['firstname'], $_POST['lastname'], $_POST['subjectcode'], $_POST['subjectdescription'], $_POST['suffix'], $_POST['course'], $_POST['year'])) {
        $uid = $_POST['uid'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename']; // Make sure to handle this if it's optional
        $lastname = $_POST['lastname'];
        $subjectcode = $_POST['subjectcode'];
        $subjectdescription = $_POST['subjectdescription'];
        $suffix = $_POST['suffix'];
        $course = $_POST['course'];
        $year = $_POST['year'];

        // Check if the uid is empty
        if (empty($uid)) {
            $response = array('success' => false, 'message' => 'UID is required.');
        } else {
            // Insert data into the users table
            $insert = "INSERT INTO users (rfidUID, firstname, middlename, lastname, subjectCode, subjectDescription, suffix, course, year, role, status) 
                VALUES ('$uid','$firstname', '$middlename', '$lastname', '$subjectcode', '$subjectdescription', '$suffix', '$course', '$year', 'student', 'enrolled')";

            if ($conn->query($insert) === TRUE) {
                // Update active status in uid table
                $updateSqlUID = "UPDATE uid SET active = '3' WHERE user_id = '$uid'";
                if ($conn->query($updateSqlUID) === TRUE) {
                    $response['success'] = true;
                    $response['message'] = 'UID recorded.';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Error updating UID status: ' . $conn->error;
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Error inserting data: ' . $conn->error;
            }
        }
    } else {
        $response = array('success' => false, 'message' => 'Required fields are missing.');
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request method.');
}

echo json_encode($response);
?>