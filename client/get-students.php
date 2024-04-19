<?php
session_start();
include '../server/config.php';

$subjectCode = $_SESSION['subjectCode'] ?? null;

if ($subjectCode) {
    $selectQuery = "SELECT * FROM users WHERE subjectCode = '$subjectCode' AND role = 'student' AND status != 'dropped' ORDER BY lastname";

    $result = $conn->query($selectQuery);

    if ($result) {
        $students = array();

        while ($data = $result->fetch_assoc()) {
            $name = $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'];
            $rfidUID = $data['rfidUID'];
            $subject = $data['subjectCode'] . ' ' . $data['subjectDescription'];
            $role = $data['role'];

            $status = '';

            $selectAttendance = "SELECT * FROM attendance WHERE attendanceSubjectCode = '$subjectCode' AND studentID = '$rfidUID' AND attendanceDate = CURDATE()";
            $result1 = $conn->query($selectAttendance);

            $absentCount = 0;
            $timeIn = '';

            if ($result1) {
                while ($data1 = $result1->fetch_assoc()) {
                    $status = $data1['attendanceStatus'];
                    $timeIn = date("d M Y h:i:s A", strtotime($data1['attendanceDate'] . ' ' . $data1['attendanceTime']));
                }
            }
           
                $students[] = array(
                    'name' => $name,
                    'rfidUID' => $rfidUID,
                    'subject' => $subject,
                    'role' => $role,
                    'status' => $status,
                    'timeIn' => $timeIn
                );
          
          
        }

        // Output the result as JSON
        header('Content-Type: application/json');
        echo json_encode($students);
    } else {
        // Query execution failed
        echo json_encode(array('error' => 'Query execution failed: ' . $conn->error));
    }
} else {
    // Handle the case where $_SESSION['subjectCode'] is not set
    echo json_encode(array('error' => 'Subject code not set in session.'));
}
?>