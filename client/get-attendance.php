<?php
session_start();
include '../server/config.php';

$subjectCode = $_SESSION['subjectCode'] ?? null;

if ($subjectCode) {
  
    $selectAttendance = "SELECT * FROM attendance WHERE attendanceSubjectCode = '$subjectCode'";
    $result1 = $conn->query($selectAttendance);

    $status = '';
    $timeIn = '';
    if ($result1) {
        $students = array();

        while($data1 = $result1->fetch_assoc()){
            $status = $data1['attendanceStatus'];
            $timeIn = date("d M Y h:i:s A", strtotime($data1['attendanceDate'] . ' ' . $data1['attendanceTime']));

            $students[] = array(
                'status' => '',
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