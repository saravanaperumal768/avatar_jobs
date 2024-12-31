<?php
include('connection.php');

if (isset($_POST['delete_job'])) {
    $job_id = $_POST['job_id'];
    $admin = $_POST['Mahendran'];

    // Perform deletion query based on the job ID
    $delete_query = "DELETE FROM emergency_reminder WHERE id = $job_id";
    $result = mysqli_query($db, $delete_query);
// echo $admin;
// exit;
    if ($result) {
        // Deletion successful
        echo '<script>alert("Job deleted successfully");</script>';
     
            echo '<script>window.location.href = "emergency_reminder.php";</script>'; // Redirect to dashboard.php if not admin
        
    } else {
        // Deletion failed
        echo '<script>alert("Failed to delete job");</script>';
        // Redirect to an error page or handle the failure accordingly
    }
}
?>
