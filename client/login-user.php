<?php
include '../server/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['uid'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $selectSql = "SELECT * FROM users WHERE rfidUID = ? AND role = 'professor'";
    $stmt = $conn->prepare($selectSql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Update the active status in the database
            $updateSql = "UPDATE uid SET active = '1' WHERE user_id = ?";
            $stmtUpdate = $conn->prepare($updateSql);
            $stmtUpdate->bind_param("s", $username);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            // Start a session
            session_start();
            $_SESSION['rfidUID'] = $row['rfidUID'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['subjectCode'] = $row['subjectCode'];
            $_SESSION['scheduleFrom'] = $row['scheduleFrom'];
            $_SESSION['scheduleTo'] = $row['scheduleTo'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['middlename'] = $row['middlename'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['suffix'] = $row['suffix'];
            

            $response = array('success' => true, 'message' => 'Login successful');
        } else {
            // Passwords do not match
            $response = array('success' => false, 'message' => 'Invalid username or password');
        }
    } else {
        // User not found
        $response = array('success' => false, 'message' => 'Invalid username or password');
    }

    $stmt->close();
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
}

echo json_encode($response);
?>
