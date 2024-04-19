<?php
session_start();
include '../server/config.php';

$subjectCode = $_SESSION['subjectCode'] ?? null;
$rfidUID = $_GET['id'] ?? null;
if ($subjectCode) {
  

    $selectQuery = "SELECT * FROM users WHERE subjectCode = '$subjectCode' AND role = 'student' AND rfidUID = '$rfidUID' ";
    

    $result = $conn->query($selectQuery);

    if ($result) {
        $students = array();

        while ($data = $result->fetch_assoc()) {
            $name = $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'];
            $subject = $data['subjectCode'] . ' ' . $data['subjectDescription'];
            $role = $data['role'];
         

            $selectAttendance = "SELECT * FROM attendance WHERE attendanceSubjectCode = '$subjectCode' AND studentID = '$rfidUID'";
            $result1 = $conn->query($selectAttendance);
      
          

            if ($result1) {
                while ($data1 = $result1->fetch_assoc()) {
                    $attendanceStatus = $data1['attendanceStatus'];
                    $attendanceDate = date("d M Y", strtotime($data1['attendanceDate']));
                    $timeIn = date("h:i:s A", strtotime($data1['attendanceTime']));
                    $id = $data1['id'];
                    $students[] = array(
                        'id' => $id,
                        'rfidUID' => $rfidUID,
                        'subject' => $subject,
                        'date' => $attendanceDate,
                        'timeIn' => $timeIn,
                        'status' => $attendanceStatus,
                    );
                

                }
            }
        
     
        
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