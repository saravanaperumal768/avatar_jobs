<?php
// process_date.php
include('connection.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jobId = $_POST['jobId'];
    $member_complete_id = $_POST['member_complete_id'];
    $assigned_by = $_POST['assigned_by'];
  
    // echo $jobId;
    // echo $newDate;

    // SQL query to update the completion data in the jobcreate table
    $updateQuery = "UPDATE jobcreate SET assigned_by='$assigned_by',  members = '$member_complete_id' WHERE id = $jobId";
    // echo   $updateQuery;
    // exit;

    // Execute the query
    $result = mysqli_query($db, $updateQuery);

    // Check if the update was successful
    if ($result) {
        $message3 = "Date Update Successfully";
    echo "<script type='text/javascript'>
            alert('$message3');
            window.opener.location.reload(); // Refresh the parent window
            window.close(); // Close this pop-up window
          </script>";
    } else {
        echo "Error updating completion data: " . mysqli_error($db);
    }
}
?>