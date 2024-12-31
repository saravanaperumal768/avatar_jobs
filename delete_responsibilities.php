<?php
// Include database connection
include("connection.php");

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Check if the ID is set
    if (isset($_POST['id'])) {
        // Sanitize the qualification ID
        $qualification_id = intval($_POST['id']);

        // Create the delete query directly
        $delete_query = "DELETE FROM qualifications WHERE id = ?";

        // Prepare and execute the query
        if ($stmt = $db->prepare($delete_query)) {
            $stmt->bind_param("i", $qualification_id);
            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
            $stmt->close();
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} catch (Exception $e) {
    echo 'error';
    error_log($e->getMessage()); // Log the error message
}

// Close the database connection
$db->close();
?>
