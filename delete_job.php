<?php
include('connection.php');

if (isset($_POST['delete_job'])) {
    $job_id = $_POST['job_id'];
    $admin = $_POST['admin'];

    // Perform deletion query based on the job ID
    $delete_query = "DELETE FROM jobcreate WHERE id = $job_id";
    $result = mysqli_query($db, $delete_query);
// echo $admin;
// exit;
    if ($result) {
        // Deletion successful
        echo '<script>alert("Job deleted successfully");</script>';
        if ($admin) {
            echo '<script>window.location.href = "dashboard.php";</script>'; // Redirect to created_me.php if admin
        } else {
            echo '<script>window.location.href = "created_me.php";</script>'; // Redirect to dashboard.php if not admin
        }
    } else {
        // Deletion failed
        echo '<script>alert("Failed to delete job");</script>';
        // Redirect to an error page or handle the failure accordingly
    }
}
?>
