<?php
session_start();
include ("connection.php");

$log_name=$_SESSION["uname"];

$name_member = "SELECT * FROM members WHERE username = '$log_name'";
$result = mysqli_query($db, $name_member);

if ($result) {
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);
        
        // Access the 'name' column from the result
        $name_member = $row['fname'];
        $name_member_id = $row['id'];
        
        // Output the name
        // echo $name_member;
        // die;
    }
}
date_default_timezone_set('Asia/Kolkata');

        
    $from = $_POST['members'];

    $query = "SELECT * FROM members WHERE id = '$from'";
$result = mysqli_query($db, $query);

if ($result) {
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);
        
        // Access the 'name' column from the result
        $from = $row['fname'] . ' ' . $row['lname'];

       
    }
}
      
    $client=$_POST['client'];
	$members=$_POST['members'];
	$job = $_POST['job'];  
	$notes=$_POST['notes'];
	$completion=$_POST['completion'];
    // $time_picker=$_POST['time_picker'];
    $entry_date = date('Y-m-d H:i:s');
    $assigned_by = $_POST['assigned_by'];
    $start_time=$_POST['time_picker'];
    $time_picker_end=$_POST['time_picker_end'];
    $job_id=$_POST['jobId'];
    $job_type = $_POST['job_type'];
    $cus_date=date("Y-m-d");
    $reference_link = isset($_POST['reference_link']) ? $_POST['reference_link'] : '';
    $layout_ideas = $_POST['layout_ideas'];

    $color_options = $_POST['color_options'];

    $targetDir = "files/";

    $originalFileName = $_FILES["pdfFiles"]["name"][0];
    // print_r($originalFileName) ;
    // exit;
    
if (!empty($_FILES['pdfFiles']['name'][0])) {
    $allowedFileTypes = array("pdf", "jpg", "jpeg", "png", "gif", "doc", "docx", "xls", "xlsx");
    $fileCount = count($_FILES['pdfFiles']['name']);
    $uploadedFiles = [];
    $fileLinks = [];

    for ($i = 0; $i < $fileCount; $i++) {
        $originalFileName = $_FILES['pdfFiles']['name'][$i];
        $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
        $uniqueFileName = 'file' . '_' . time() . '_' . $i . '.' . $fileType;
        $targetFile = $targetDir . $uniqueFileName;

        if (!in_array($fileType, $allowedFileTypes)) {
            $message1 = "Sorry, only PDF, images, doc, and excel files are allowed";
            echo "<script type='text/javascript'>alert('$message1');</script>";
            error_log("Detected File Type: $fileType");
        } else {
            if (move_uploaded_file($_FILES['pdfFiles']['tmp_name'][$i], $targetFile)) {
                $uploadedFiles[] = "https://avatarglobalservices.com/avatarjobs/files/" . $uniqueFileName;
            } else {
                $message2 = "Error uploading files. Please try again.";
                echo "<script type='text/javascript'>alert('$message2');</script>";
            }
        }
    }

    if (!empty($uploadedFiles)) {
        $fileLinksImploded = implode("\n", $uploadedFiles);

        $sql = "UPDATE jobcreate SET clientname='$client', job='$job', members='$members', notes='$notes', job_type='$job_type', completion='$completion', start_time='$start_time', layout_ideas='$layout_ideas', color_options='$color_options', time_comp='$time_picker_end', reference='$fileLinksImploded', reference_link='$reference_link', entry_date='$entry_date', assigned_by='$assigned_by' WHERE id='$job_id'";
        // echo $sql;
        // exit;
        $result = mysqli_query($db, $sql);

        $message3 = "Date Update Successfully";
        echo "<script type='text/javascript'>
                alert('$message3');
                window.opener.location.reload(); // Refresh the parent window
                window.close(); // Close this pop-up window
              </script>";
    } 
}
else {
//   , cus_date='$cus_date'
       $sql2 = "UPDATE jobcreate SET clientname='$client', job='$job', members='$members', notes='$notes', job_type='$job_type', completion='$completion', start_time='$start_time',  layout_ideas='$layout_ideas', color_options='$color_options', time_comp='$time_picker_end',   reference_link='$reference_link', entry_date='$entry_date', assigned_by='$assigned_by' WHERE id='$job_id'";
    //   echo $sql2;
    //   exit;
        $result2 = mysqli_query($db, $sql2);
     
        $message3 = "Date Update Successfully";
                echo "<script type='text/javascript'>
                        alert('$message3');
                        window.opener.location.reload(); // Refresh the parent window
                        window.close(); // Close this pop-up window
                      </script>";
      
    }
    

   
?>
