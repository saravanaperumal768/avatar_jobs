<?php
include('connection.php');

if (isset($_POST['delete_job'])) {
    $job_id = $_POST['job_id'];

    // Perform deletion query based on the job ID
    $delete_query = "DELETE FROM  meeting WHERE id = $job_id";
    $result = mysqli_query($db, $delete_query);

    if ($result) {
        // Deletion successful
        echo '<script>alert("Meeting deleted successfully");</script>';
        echo '<script>window.location.href = "meetings.php";</script>'; // Redirect to the page after deletion
    } else {
        // Deletion failed
        echo '<script>alert("Failed to delete job");</script>';
    }
}
?>
