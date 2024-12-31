<?php
include('connection.php');

if (isset($_POST['delete_job'])) {
    $job_id = $_POST['job_id'];

    // Perform deletion query based on the job ID
    $delete_query = "DELETE FROM job_type WHERE job_type_id = $job_id";
    // echo $delete_query;
    // exit;
    $result = mysqli_query($db, $delete_query);

    if ($result) {
        // Deletion successful
        echo '<script>alert("Job Type deleted successfully");</script>';
        echo '<script>window.location.href = "job_type.php";</script>'; // Redirect to the page after deletion
    } else {
        // Deletion failed
        echo '<script>alert("Failed to delete job");</script>';
    }
}
?>
