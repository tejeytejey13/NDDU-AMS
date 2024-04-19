<?php
include '../server/config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $select = "SELECT * FROM users INNER JOIN uid ON users.rfidUID = uid.user_id WHERE uid.active = '0' AND users.role = 'professor' ORDER BY uid.id DESC LIMIT 1";
    $query = $conn->query($select);

    if ($query) {
        $response = array();

        if ($query->num_rows > 0) {
            // Fetch the data
            while ($data = $query->fetch_assoc()) {
                $response[] = $data['user_id'];
            }
        }

        echo json_encode($response);
    } else {
        // Query execution failed
        echo json_encode(array("error" => "Query execution failed: " . $conn->error));
    }
}
?>