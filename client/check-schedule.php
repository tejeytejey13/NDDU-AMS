<?php
include '../server/config.php';

$currentTime = date('H:i');  // Get current time in 'HH:MM' format

$nextUserQuery = "SELECT * FROM users WHERE scheduleTo > '$currentTime' ORDER BY scheduleTo ASC LIMIT 1";
$result = $conn->query($nextUserQuery);

if ($result->num_rows > 0) {
    $nextUser = $result->fetch_assoc();
    $scheduleTo = $nextUser['scheduleTo'];

    $fiveMinutesBeforeScheduleTo = date('H:i', strtotime($scheduleTo) - 300);
    if ($currentTime >= $fiveMinutesBeforeScheduleTo) {
        echo json_encode(array('status' => true, 'user' => $nextUser));
    } else {
        echo json_encode(array('status' => false, 'error' => 'Not enough time remaining'));
    }
} else {
    echo json_encode(array('status' => false, 'error' => 'No next user found'));
}

$conn->close();
?>
