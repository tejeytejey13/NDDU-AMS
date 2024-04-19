<?php
session_start();
include '../server/config.php';

$subjectCode = $_SESSION['subjectCode'] ?? null;

if ($subjectCode) {
  

    $selectQuery = "SELECT * FROM users WHERE subjectCode = '$subjectCode' AND role = 'student' ORDER BY lastname";
    

    $result = $conn->query($selectQuery);

    if ($result) {
        $students = array();

        while ($data = $result->fetch_assoc()) {
            $name = $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'];
            $rfidUID = $data['rfidUID'];
            $subject = $data['subjectCode'] . ' ' . $data['subjectDescription'];
            $role = $data['role'];
           

            $selectAttendance = "SELECT * FROM attendance WHERE attendanceSubjectCode = '$subjectCode' and studentID = '$rfidUID'";
            $result1 = $conn->query($selectAttendance);
        
            $presentCount = 0;
            $lateCount = 0;
            $absentCount = 0;
        
            if ($result1) {
                while ($data1 = $result1->fetch_assoc()) {
                    $attendanceStatus = $data1['attendanceStatus'];
        
                    switch ($attendanceStatus) {
                        case 'Present':
                            $presentCount++;
                            break;
                        case 'Late':
                            $lateCount++;
                            break;
                        case 'Absent':
                            $absentCount++;
                            break;
                    }
                }
            }
            
            if($absentCount == 7){
                $updateQuery = "UPDATE users SET status = 'dropped' WHERE rfidUID = '$rfidUID' AND subjectCode = '$subjectCode'";
                $conn->query($updateQuery);
            }
        
            if($absentCount != 3){
                $students[] = array(
                    'name' => $name,
                    'rfidUID' => $rfidUID,
                    'subject' => $subject,
                    'role' => $role,
                    'presentCount' => $presentCount,
                    'lateCount' => $lateCount,
                    'absentCount' => $absentCount,
                );
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