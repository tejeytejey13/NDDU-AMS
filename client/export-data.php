<?php
session_start();
include '../server/config.php';

$subjectCode = $_SESSION['subjectCode'] ?? null;
$selectedDate = $_POST['date'] ?? null; // Assuming the form is submitted using POST method

if ($subjectCode && $selectedDate) { // Check if both subject code and selected date are set
    $selectQuery = "SELECT * FROM users WHERE subjectCode = '$subjectCode' AND role = 'student' ORDER BY lastname"; 
    
    $result = $conn->query($selectQuery);

    if ($result) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="student_attendance_records.csv"');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Write CSV header
        fputcsv($output, array('Name', 'Subject', 'Course', 'Year', 'Present', 'Late', 'Absent', 'Date', 'Time', 'Attendance Status', 'Student Status'));

        while ($data = $result->fetch_assoc()) {
            $name = $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'] . ' ' . $data['suffix'];
            $rfidUID = $data['rfidUID'];
            $subject = $data['subjectCode'] . ' ' . $data['subjectDescription'];
            $course = $data['course'];
            $year = $data['year'];

            $attendanceStatus = "Not Recorded";

            $presentCount = 0;
            $lateCount = 0;
            $absentCount = 0;
            $date = ""; 
            $time = "";

            // Modify the query to filter attendance records based on selected date
            $selectAttendance = "SELECT * FROM attendance WHERE attendanceSubjectCode = '$subjectCode' AND studentID = '$rfidUID' AND attendanceDate = '$selectedDate'"; 
            $result1 = $conn->query($selectAttendance);

            if ($result1) {
                while ($data1 = $result1->fetch_assoc()) {
                    $attendanceStatus = $data1['attendanceStatus'];
                    $time = $data1['attendanceTime'];
                    $date = $data1['attendanceDate']; 

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

                // Write CSV row only if attendance records are found for the selected date
                if ($result1->num_rows > 0) {
                    $studentStatus = $data['status'];

                    if ($absentCount == 7) {
                        $updateQuery = "UPDATE users SET status = 'dropped' WHERE rfidUID = '$rfidUID' AND subjectCode = '$subjectCode'";
                        $conn->query($updateQuery);
                    }

                    fputcsv($output, array($name, $subject, $course, $year, $presentCount, $lateCount, $absentCount, $date, $time, $attendanceStatus, $studentStatus));
                }
            }
        }

        // Close output stream
        fclose($output);
    } else {
        echo "Query execution failed: " . $conn->error;
    }
} else {
    echo "Subject code or date not set.";
}
?>
