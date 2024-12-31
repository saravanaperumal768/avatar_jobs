<?php
session_start();
include("connection.php");

if (isset($_POST['job_id_start']) && isset($_POST['job_start_again_time'])) {
    $job_id_start = mysqli_real_escape_string($db, $_POST['job_id_start']);
    $job_start_again_time = mysqli_real_escape_string($db, $_POST['job_start_again_time']);
    $currentDate = date('Y-m-d');

    // Check if the job is already started again
    $sqlCheck = "SELECT job_start_again FROM jobcreate WHERE id = '$job_id_start'";
    $resultCheck = mysqli_query($db, $sqlCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);

    if (!empty($rowCheck['job_start_again'])) {
        echo 'The job is already restarted.';
    } else {
        // Update start again time in the database
        $sql = "UPDATE jobcreate SET job_start_again = '$job_start_again_time' WHERE id = '$job_id_start'";

        if (mysqli_query($db, $sql)) {
            echo 'Job restarted successfully';
        } else {
            echo 'Error updating restart status: ' . mysqli_error($db);
        }
    }
}
?>
