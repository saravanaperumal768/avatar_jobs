<?php
session_start();
include("connection.php");

if (isset($_POST['job_id_start']) && isset($_POST['job_start_time'])) {
    $job_id_start = mysqli_real_escape_string($db, $_POST['job_id_start']);
    $job_start_time = mysqli_real_escape_string($db, $_POST['job_start_time']);
    $member_jobs = mysqli_real_escape_string($db, $_POST['member_jobs']);  // Update this line
    $currentDate = date('Y-m-d');

    // Check if any job is already active today
    $sqlCheck = "SELECT COUNT(*) as active_jobs FROM jobcreate WHERE completion = '$currentDate' AND members = '$member_jobs' AND job_start_at <> '' AND job_pause_at = '' AND close_time = ''";
   
    $resultCheck = mysqli_query($db, $sqlCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);
    // print_r($rowCheck['active_jobs']);
    
    if ($rowCheck['active_jobs'] > 0) {
        echo 'Another job is already started today. Kindly close it first.';
    } else {
        // Update status in the database
        $sql = "UPDATE jobcreate SET job_start_at = '$job_start_time' WHERE id = '$job_id_start'";

        if (mysqli_query($db, $sql)) {
            echo 'Status updated successfully';
        } else {
            echo 'Error updating status: ' . mysqli_error($db);
        }
    }
}
?>
