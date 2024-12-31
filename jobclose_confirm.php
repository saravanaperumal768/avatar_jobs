<?php
include('connection.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Assuming you have a database connection in $db
    date_default_timezone_set('Asia/Kolkata');

    $recordId = $_POST['jobclose_id'];
    $jobStatus = 'Closed Completed';
    $close_time = date('Y-m-d H:i:s');
    $client_name1 = $_POST['client_name1'];
    $job_name = $_POST['job_name'];
    $filelink = $_POST['filelink'];
    $notes_output = $_POST['notes_output'];
    $cus_date = date("Y-m-d");
  
    $uploadedFiles = [];
    $fileCount = count($_FILES['job_close_file']['name']);
    $allowedFileTypes = ['pdf', 'JPG', 'PNG', 'webp', 'WEBP', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx']; // Add allowed file types as needed
    $uploadDirectory = 'clientfiles/'; // Set your upload directory


   
  for ($i = 0; $i < $fileCount; $i++) {
    if (!empty($_FILES['job_close_file']['name'][$i])) {
      $originalFileName = $_FILES['job_close_file']['name'][$i];
      $fileTmpName = $_FILES['job_close_file']['tmp_name'][$i];

      // Sanitize file name
      $fileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalFileName);
      $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

      // Replace spaces and construct new file name
         $clientNameSanitized = str_replace([' ', '-', '.', '+', '/'], '', $client_name1);

        $jobNameSanitized = str_replace([' ', '-', '.', '+','/'], '', $job_name);
      $uniqueFileName = $clientNameSanitized . '_' . $jobNameSanitized . '_' . uniqid() . '.' . $fileExt;
      $fileServerPath = $uploadDirectory . $uniqueFileName;
 

      // Check file type and move file
      if (!in_array($fileExt, $allowedFileTypes)) {
        $message = "Sorry, only PDF, images, doc, and excel files are allowed.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        error_log("Detected File Type: $fileExt");
      } else {
        if (move_uploaded_file($fileTmpName, $fileServerPath)) {
          $fileUrl = 'https://avatarglobalservices.com/avatarjobs/' . $fileServerPath;
          $fileUrl = str_replace('\\', '/', $fileUrl);
          $uploadedFiles[] = $fileUrl;
        } else {
           $message = "Error uploading file. Please try again.";
          echo "<script type='text/javascript'>alert('$message'); window.location.href = 'job_submission.php';</script>";
          exit;
        }
      }
    }
  } 

    // Encode the uploaded files array to JSON without escaping slashes

    $uploadedFilesJSON = implode("\n", $uploadedFiles);


    // Handle empty cases
    if (empty($uploadedFiles)) {
        $uploadedFilesJSON = '';
    }
    if (empty($filelink)) {
        $filelink = '';
    }

    $query = "UPDATE jobcreate SET job_status = '$jobStatus', job_close_file='$uploadedFilesJSON', filelink='$filelink', notes_output='$notes_output', close_time = '$close_time' WHERE id = $recordId";
// echo $query;
// exit;
    $stmt = mysqli_query($db, $query);

    if ($stmt) {
    //     $jobDetailsQuery = "SELECT * FROM jobcreate WHERE id = $recordId";
    // $jobDetailsResult = mysqli_query($db, $jobDetailsQuery);
    // $jobData = mysqli_fetch_assoc($jobDetailsResult);

    // $job = $jobData['job'];
    // $Client_name_send = $jobData['clientname'];

    // $subject = 'Job Status Update';


    // $uploadedFilesString = implode("\n", $uploadedFiles);
    
    //     $message = "Dear Client,\n\n" .
    //             "This is to inform you that the job status for '$job' has been updated.\n\n" .
    //        "File Link: $filelink\n\n" .
    //        "File Uploaded Links:\n$uploadedFilesString\n\n" .
    //        "Thank you.";

    //        $mail_enquiry = "SELECT * FROM clients where name ='$Client_name_send'";
         
    //        $result_enquiry = mysqli_query($db, $mail_enquiry);
    //        $from = "business@avatarprints.com"; 
    //        $headers = "From: $from\r\n";

    //     while ($row = mysqli_fetch_assoc($result_enquiry)) {
    //         $to = $row['email'];
          

          
    //         if (mail($to, $subject, $message, $headers)) {
      // Mail sent to Client Mail ID & Job Closed
                $message3 = "Job Closed Successfully";
                echo "<script type='text/javascript'>alert('$message3'); window.location.href = 'job_submission.php';</script>";
            } else {
             
                $message4 = "Please check there is an error in the message";
                echo "<script type='text/javascript'>alert('$message4'); window.location.href = 'index.php';</script>";
            }
        // }
    
        // echo "<script type='text/javascript'>alert('Job Closed Successfully'); window.location.href = 'job_submission.php';</script>";
    // } 

    mysqli_close($db);
}
?>
