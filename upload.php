<?php
session_start();
error_reporting(0);
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
 $dateString = $_POST['completion'];
    $dateObject = DateTime::createFromFormat('F d, Y', $dateString);
    $completion = $dateObject->format('Y-m-d');
	// $completion=$_POST['completion'];

   $dateString2 = $_POST['Date_of_post'];
    if(!empty($dateString2)){
    $dateObject2 = DateTime::createFromFormat('F d, Y', $dateString2);
    $date_of_post = $dateObject2->format('Y-m-d');
    }else{
        $date_of_post='0';
    }

    $time1 = $_POST['time_picker'];
    $time2 = $_POST['time_picker_end'];
    
    $timeObject1 = DateTime::createFromFormat('h:ia', $time1);
    $timeObject2 = DateTime::createFromFormat('h:ia', $time2);
    
    $start_time = $timeObject1->format('H:i');
    $time_picker_end = $timeObject2->format('H:i');
    
     // $start_time=$_POST['time_picker'];
    // $time_picker_end=$_POST['time_picker_end'];
    
    $entry_date = date('Y-m-d H:i:s');
    $assigned_by = $_POST['assigned_by'];
    $reference_link= $_POST['reference_link'];
    $job_type = $_POST['job_type'];
      if ($job_type == '0') {
        $message3 = "Record Not Added Choose Job Type Properly";
            echo "<script type='text/javascript'>alert('$message3'); window.location='job_creation.php';</script>";
            exit;
    }
        $urgent = $_POST['schedule'];
    $important = $_POST['schedule2'];
    
    $layout_ideas = $_POST['layout_ideas'];

    $color_options = $_POST['color_options'];
    
    $cus_date=date("Y-m-d");
    
    $type_of_work = $_POST['type_of_work'];
$targetDir = "files/";
$allowedFileTypes = array("pdf", "jpg", "jpeg", "png", "gif", "doc", "docx", "xls", "xlsx");

if (!empty($_FILES['pdfFiles']['name'][0])) {
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

    // Process the uploaded files (e.g., save file links to the database)
    if (!empty($uploadedFiles)) {
        $to = "business@avatarprints.com";
        $subject = "Job Creation Mail From Avatar Jobs";
        
        // Append each file link individually
        foreach ($uploadedFiles as $fileLink) {
            $fileLinks[] = $fileLink;
        }

        $fileLinksImploded = implode("\n", $fileLinks);

        $messages = "This message was sent from:\n" .
            "Job Creation Mail From Avatar Jobs Website\n" .
            "------------------------------------------------------------------\n\n" .
            "Client Name       :\t $client\n\n" .
            "Name of the Job       :\t $job\n\n" .
            "Assigned To      :\t $assigned_by\n\n" .
            "Notes and Other Details     	:\t $notes\n\n" .
            "Date of Completion     	:\t $completion\n\n" .
            "Date of Post     	:\t $date_of_post\n\n" .
            "Start Time:\t $start_time\n\n" .
            "End Time:\t $time_picker_end\n\n" .
            "File Links     	:\n$fileLinksImploded\n\n" .
            "Reference Link     	:\t $reference_link\n\n";

        $headers  = "From: $from\r\n";

        if (mail($to, $subject, $messages, $headers)) {
             $sql = "INSERT INTO jobcreate (clientname, job, members, notes, job_type, type_of_work, layout_ideas, color_options, completion, date_of_post, start_time, time_comp, reference, reference_link, entry_date, assigned_by, urgent, important, cus_date) VALUES ('$client', '$job', '$members', '$notes', '$job_type', '$type_of_work', '$layout_ideas', '$color_options', '$completion', '$date_of_post', '$start_time', '$time_picker_end', '$fileLinksImploded', '$reference_link', '$entry_date', '$assigned_by', '$urgent', '$important', '$cus_date')";
            
            $result = mysqli_query($db, $sql);

            $message3 = "Record Added Successfully";
            echo "<script type='text/javascript'>alert('$message3'); window.location='job_creation.php';</script>";
        } else {
            echo "Error sending email";
        }
    } else {
        $message2 = "Please Fill the Form Properly";
        echo "<script type='text/javascript'>alert('$message2');</script>";
    }


}

       
else {
        // No image uploaded, continue the process without interrupting
        // Process and send email, insert into the database, etc.
        // Additional handling when no image is uploaded
        $to = "business@avatarprints.com";
        $subject = "Job Creation Mail From Avatar Jobs";
    
        $messages = "This message was sent from:\n" .
            "Job Creation Mail From Avatar Jobs Website\n" .
            // Add the rest of your message content here...
            "Date of Completion:\t $completion\n\n" .
               "Start Time:\t $start_time\n\n" .
            "End Time:\t $time_picker_end\n\n" .
            "File Link:\t No file uploaded\n\n"; // Placeholder for no file uploaded
    
        $headers = "From: $from\r\n";
    
        if (mail($to, $subject, $messages, $headers)) {
            // Proceed with inserting into the database or any other necessary action
          
        } else {
            // echo "Failed to send mail."; // Handling failed email sending
            echo "";
        }
        $sql = "INSERT INTO jobcreate (clientname, job, members, notes, job_type, type_of_work, layout_ideas, color_options, completion, date_of_post, start_time, time_comp, reference, reference_link, entry_date, assigned_by, urgent, important, cus_date) VALUES ('$client', '$job', '$members', '$notes', '$job_type', '$type_of_work', '$layout_ideas', '$color_options', '$completion', '$date_of_post','$start_time', '$time_picker_end', '', '$reference_link', '$entry_date', '$assigned_by', '$urgent', '$important', '$cus_date')";
        // echo $sql;
        // exit;
        $result = mysqli_query($db, $sql);
        // echo $sql;
        // exit;
        $message3 = "Record Added Successfully";
        echo "<script type='text/javascript'>alert('$message3'); window.location='job_creation.php';</script>";
    }
    
    
    

   
?>
