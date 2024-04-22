<?php
date_default_timezone_set('Asia/Manila');

include '../server/config.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['uid'], $_POST['subjectcode'], $_POST['from'], $_POST['to'])) {
        $uid = $_POST['uid'];
        $subjectcode = $_POST['subjectcode'];
        $timeFrom = $_POST['from'];
        $timeTo = $_POST['to'];

        // Check if the UID matches the subject code
        $checkSubjectQuery = "SELECT * FROM users WHERE rfidUID = '$uid' AND status != 'dropped' AND subjectCode = '$subjectcode'";
        $resultCheckSubject = $conn->query($checkSubjectQuery);

        if ($resultCheckSubject->num_rows > 0) {
            $checkAttendanceQuery = "SELECT * FROM attendance 
                                    WHERE studentID = '$uid' 
                                    AND attendanceSubjectCode = '$subjectcode' 
                                    AND attendanceDate = CURDATE()";

            $resultCheckAttendance = $conn->query($checkAttendanceQuery);
            
            $currentDateTime = time(); 
            $expectedTime = strtotime(date("Y-m-d $timeFrom")); 
            $diffMinutes = abs($currentDateTime - $expectedTime) / 60; 
            
            if ($diffMinutes >= 30) {
                $attendanceStatus = 'Absent';
            } elseif ($diffMinutes >= 15) {
                $attendanceStatus = 'Late';
            } elseif ($diffMinutes >= 0 && $diffMinutes < 15) {
                $attendanceStatus = 'Present';
            }

            if ($resultCheckAttendance->num_rows == 0) {
                // Insert attendance data
                $insert = "INSERT INTO attendance (studentID, attendanceDate, attendanceTime, attendanceStatus, attendanceSubjectCode) 
                    VALUES ('$uid', CURDATE(), NOW(), '$attendanceStatus', '$subjectcode')";

                $updateSqlUID = "UPDATE uid SET
                    active = '3'
                    WHERE user_id = '$uid'";

                if ($conn->query($insert) === TRUE && $conn->query($updateSqlUID) === TRUE) {
                    $response['success'] = true;
                    $response['message'] = $attendanceStatus;
                } else {
                    $response['message'] = 'Error inserting attendance: ' . $conn->error;
                }
            } else {
                // User has already tapped for attendance today in the subjectCode
                $updateSqlUID1 = "UPDATE uid SET
                    active = '3'
                    WHERE user_id = '$uid'";
                if ($conn->query($updateSqlUID1) === TRUE) {
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Error updating UID status: ' . $conn->error;
                }

                $response['success'] = false;
                $response['message'] = 'User has already tapped for attendance today in the subject.';
            }
        } else {
        }

        $conn->close();
    } else {
        $response = array('success' => false, 'message' => 'Invalid POST data: "uid", "subjectcode", "from", and "to" keys are required.');
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request method.');
}

echo json_encode($response);
?>