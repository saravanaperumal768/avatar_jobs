<?php
// process_date.php
include('connection.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jobId = $_POST['jobId'];
    $newDate = $_POST['date'];
    $time = $_POST['timepicker'];
    // echo $jobId;
    // echo $newDate;

    // SQL query to update the completion data in the jobcreate table
    $updateQuery = "UPDATE jobcreate SET completion = '$newDate',  time_comp='$time' WHERE id = $jobId";
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