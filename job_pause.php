<?php
session_start();
include("connection.php");

if (isset($_POST['job_id_start']) && isset($_POST['job_pause_time'])) {
    $job_id_start = mysqli_real_escape_string($db, $_POST['job_id_start']);
    $job_pause_time = mysqli_real_escape_string($db, $_POST['job_pause_time']);
    $currentDate = date('Y-m-d');

    // Check if the job is already paused
    $sqlCheck = "SELECT job_pause_at FROM jobcreate WHERE id = '$job_id_start'";
    $resultCheck = mysqli_query($db, $sqlCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);

    if (!empty($rowCheck['job_pause_at'])) {
        echo 'The job is already paused.';
    } else {
        // Update pause time in the database
        $sql = "UPDATE jobcreate SET job_pause_at = '$job_pause_time' WHERE id = '$job_id_start'";

        if (mysqli_query($db, $sql)) {
            echo 'Job paused successfully';
        } else {
            echo 'Error updating pause status: ' . mysqli_error($db);
        }
    }
}
?>
