<?php
session_start();
include 'config.php';
header('Content-Type: application/json');
$postData = file_get_contents("php://input");
$jsonData = json_decode($postData, true);

$response = array('success' => false, 'message' => '');

if (isset($jsonData['uid'])) {
    $jsonUID = $jsonData['uid'];
    $currentHour = date("H");

    $checkAttendanceQuery = "SELECT * FROM users 
                             INNER JOIN attendance ON users.rfidUID = attendance.studentID  
                             WHERE users.rfidUID = ? 
                             AND attendance.attendanceDate = CURDATE()
                             AND HOUR(attendance.attendanceTime) = ?
                             AND users.role = 'student'";

    $stmtCheck = $conn->prepare($checkAttendanceQuery);
    $stmtCheck->bind_param("ss", $jsonUID, $currentHour);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows == 0) {
        // Continue with attendance insertion for students only
        $lastAttendanceTimeQuery = "SELECT MAX(attendanceTime) AS lastAttendanceTime FROM attendance WHERE studentID = ?";
        $stmtLastAttendanceTime = $conn->prepare($lastAttendanceTimeQuery);
        $stmtLastAttendanceTime->bind_param("s", $jsonUID);
        $stmtLastAttendanceTime->execute();
        $stmtLastAttendanceTime->bind_result($lastAttendanceTime);
        $stmtLastAttendanceTime->fetch();
        $stmtLastAttendanceTime->close();

        if (!$lastAttendanceTime || (strtotime($lastAttendanceTime) < strtotime('-1 hour'))) {
            $insertAttendanceQuery = "INSERT INTO attendance (studentID, attendanceDate, attendanceTime, attendanceStatus, subjectCode) VALUES (?, CURDATE(), NOW(), 'Present', '')";
            $stmtInsert = $conn->prepare($insertAttendanceQuery);
            $stmtInsert->bind_param("ss", $jsonUID, $subjectCode);

            if ($stmtInsert->execute()) {
                $response['success'] = true;
                $response['message'] = 'Attendance recorded.';
            } else {
                $response['message'] = 'Error inserting attendance: ' . $stmtInsert->error;
            }

            $stmtInsert->close();
        } else {
            $response['message'] = 'Another attendance within the last hour is not allowed.';
        }
    } else {
        $response['message'] = 'Attendance already recorded for this student and subject.';
    }

    $stmtCheck->close();
} else {
    $response['message'] = 'UID not provided.';
}

echo json_encode($response);
?>
