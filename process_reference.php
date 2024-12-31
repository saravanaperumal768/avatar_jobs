<?php
include('connection.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $targetDir = "files/";
    $originalFileName = $_FILES["pdfFile"]["name"];
    $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    $uniqueFileName = 'file' . '_' . time() . '.' . $fileType;
    $targetFile = $targetDir . $uniqueFileName;

    echo $originalFileName;

    $allowedFileTypes = array("pdf", "jpg", "jpeg", "png", "gif", "doc", "docx", "xls", "xlsx");

    if (!in_array($fileType, $allowedFileTypes)) {
        $message1 = " Sorry, only PDF, images, doc, and excel files are allowed";
        echo "<script type='text/javascript'>alert('$message1');</script>";
        error_log("Detected File Type: $fileType");
    } else {
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
            $fileLink = "" . $targetFile; 

            // Assuming $jobId is defined somewhere in your code
            $jobId = $_POST['jobId'];

            // SQL query to update the completion data in the jobcreate table
            $updateQuery = "UPDATE jobcreate SET reference='$fileLink' WHERE id = $jobId";

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
    }
}
?>
