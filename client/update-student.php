<?php
include '../server/config.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["idd"];
    $studentId = $_POST["id"];
    $date = $_POST['date'];
    $newStatus = $_POST["status"];

    $updateStatement = "UPDATE attendance SET 
                        attendanceStatus = '$newStatus'
                        WHERE id = '$id'";

    if ($conn->query($updateStatement) === TRUE) {
        $response['success'] = true;
        $response['message'] = $newStatus ;
    } else {
        $response['success'] = false;
        $response['error'] = 'Error updating student status: ' . $conn->error;
    }

    echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}
?>
