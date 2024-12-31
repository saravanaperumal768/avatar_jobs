<?php
include("connection.php"); // Include your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']); // Get ID from POST data

    // Validate ID (e.g., check if it's valid)
    if ($id > 0) {
        // Sanitize input to prevent SQL injection
        $id = $db->real_escape_string($id);

        // Prepare and execute the delete query
        $query = "DELETE FROM careers WHERE id = $id";
        $result = $db->query($query);

        if ($result) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false, 'error' => $db->error];
        }
    } else {
        $response = ['success' => false, 'error' => 'Invalid ID'];
    }

    

    $db->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
