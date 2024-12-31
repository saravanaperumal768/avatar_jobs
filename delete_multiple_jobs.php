<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selectedIDs']) && !empty($_POST['selectedIDs'])) {
        // Sanitize received IDs to prevent SQL injection
        $selectedIDs = array_map('intval', $_POST['selectedIDs']);

        // Implode the IDs array to use in the SQL query
        $idsString = implode(',', $selectedIDs);

        // Prepare and execute the DELETE query
        $deleteQuery = "DELETE FROM jobcreate WHERE id IN ($idsString)";
        $result = mysqli_query($db, $deleteQuery);

        if ($result) {
            // Deletion successful
            echo 'Success';
        } else {
            // Deletion failed
            echo 'Error';
        }
    } else {
        // No IDs were received
        echo 'No IDs received';
    }
} else {
    // Request method is not POST
    echo 'Invalid request method';
}
?>
