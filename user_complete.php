<?php

error_reporting(0);
ob_start();
session_start();
include("connection.php");
$password1=mysqli_real_escape_string($db,stripslashes($_SESSION["hacses156"]));
$ip1=mysqli_real_escape_string($db,stripslashes($_SESSION["hacses157"]));
$ldate1=mysqli_real_escape_string($db,stripslashes($_SESSION["hacses158"]));

 $selquery="select * from logs where pwd1='$password1' and ip1='$ip1' and ldate1='$ldate1'";
//   echo $selquery;
//   die;

 $result=mysqli_query($db,$selquery);
 $count=mysqli_num_rows($result);
 
 if($count==0)   {
 header("location: index.php");
 //mysqli_close();

}
elseif($count==1)
{

$client=1;  
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



include('top.php');

$closed=1;

?>


<?php
include('left.php');
include('nav.php');
?>  
<style>
    .mr_15{
        margin-top:15px;
    }

        .filter_assigned {
    margin-right: 20px;
    margin: 0px 15px 9px 0px;
    border: 1px solid #550d9e;
    border-radius: 5px;
    padding: 4px 13px;
}
  
</style>
      
     <div class="content-page">
<div class="container-fluid">
       <div class="row">
           
           <div class="col-lg-12">
                    
               <div class="row">
                   <div class="col-lg-12">
                       <div class="card card-block card-stretch">
                           <div class="card-body p-0">
                               <div class="d-flex justify-content-between align-items-center p-3">
                                   <h5 class="font-weight-bold">JOB List</h5>
                                   <!-- <a href="export_complete.php">
                                       <button class="btn btn-secondary btn-sm">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                           </svg>
                                           Export
                                       </button>
                                   </a> -->
                               </div>
                               <div class="table-responsive">
                                   <!-- <div class="" style="margin: 0px 18px;">
                                   <button type="button" class="btn btn-danger" id="deleteSelected" style="background:red;"> <i class="fa fa-trash-o"></i>&nbsp; Delete Selected</button>
                                   </div> -->
                                   <table class="table data-table mb-0">
                                    
                                   
                                    <thead class="table-color-heading">
                                        <tr>
                                            <th scope="col">Client Name</th>
                                            <th scope="col">Name of the Job / <br> Date & Time <br>Of Completion</th>
                                            <th scope="col">Assigned By</th>
                                            <th scope="col">Job File</th>
                                             <th scope="col">File Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $start_date = $_POST['start_date'] ?? null;
                                        $end_date = $_POST['end_date'] ?? null;

                                   // Initialize the SQL query
                                                        $sql2 = "SELECT * FROM jobcreate 
                                                        WHERE members = '$name_member_id' 
                                                        AND job_status <> '' 
                                                        AND completion >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";

                                                        // Check if both start and end dates are provided
                                                        if ($start_date !== null && $end_date !== null) {
                                                        // Append the date filter to the query
                                                        $sql2 .= " AND completion BETWEEN '$start_date' AND '$end_date'";
                                                        }

                                                        // Order the results by the completion date in descending order
                                                        $sql2 .= " ORDER BY completion DESC";


                                        $result2 = mysqli_query($db, $sql2);
                                        while ($db_field2 = mysqli_fetch_array($result2)) {
                                            $members_id_no = $db_field2["members"];
                                            $fileLinks = explode("\n", $db_field2["reference"]);

                                            // Check for completion date nearing today's date
                                            $completionDate = strtotime($db_field2['completion']); // Convert completion date to a timestamp
                                            $today = strtotime(date('Y-m-d')); // Today's date as a timestamp

                                            // Calculate the difference in days
                                            $dateDifference = floor(($completionDate - $today) / (60 * 60 * 24)); 
                                    ?>
                                            <tr class="white-space-no-wrap">
                                                <td><?php echo $db_field2["clientname"] ?></td>
                                                <td><?php echo $db_field2["job"] ?> / <br>
                                                    <?php
                                                        if ($dateDifference >= 0 && $dateDifference <= 1) {
                                                            echo '<span style="color: red;">' . $db_field2['completion'] . '</span>'; // Highlight in red
                                                        } else {
                                                            echo $db_field2['completion']; // Normal display
                                                        }
                                                    ?> /<br>
                                                    <?php echo $db_field2["time_comp"] ?> 
                                                </td>
                                                <td class="">
                                                <?php
                                                    $recordId = $db_field2["id"];
                                                    $sqlUpdated = "SELECT * FROM jobcreate WHERE id = '$recordId'";
                                                    $resultUpdated = mysqli_query($db, $sqlUpdated);

                                                    while ($row = mysqli_fetch_assoc($resultUpdated)) {
                                                        $selectedMember = $row['assigned_by'];
                                                        $job_status = $row['job_status'];
                                                ?>
                                                <?php echo $selectedMember ?>
                                                <?php } ?>
                                                </td>
                                                <td>
                                           <?php
                                           if (!empty($db_field2["job_close_file"])) {
                                               // Use a separate variable for the file link
                                               $fileLinks = explode("\n", $db_field2["job_close_file"]);
                                               // $jobCloseFileLink = $db_field2["job_close_file"];
                                               // echo '<a href="' . $jobCloseFileLink . '" target="_blank">Job File</a><br>';

                                               // Display additional file links if available
                                               if (!empty($fileLinks)) {
                                                   foreach ($fileLinks as $additionalFileLink) {
                                                       echo '<a href="' . $additionalFileLink . '" target="_blank">Job File</a><br>';
                                                   }
                                               }
                                           }
                                           ?>
                                       </td>

                                       <td>
                                           <?php
                                           if (!empty($db_field2["filelink"])) {
                                               // Use a separate variable for the file link
                                               $fileLinks = explode("\n", $db_field2["filelink"]);
                                               // $jobCloseFileLink = $db_field2["job_close_file"];
                                               // echo '<a href="' . $jobCloseFileLink . '" target="_blank">Job File</a><br>';

                                               // Display additional file links if available
                                               if (!empty($fileLinks)) {
                                                   foreach ($fileLinks as $additionalFileLink) {
                                                       echo '<a href="' . $additionalFileLink . '" target="_blank">File Link</a><br>';
                                                   }
                                               }
                                           }else{
                                               echo '-';
                                           }
                                           ?>
                                       </td>
                                                
                                            </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
     </div>
   </div>
   <!-- Wrapper End-->
   <script>
   function openDatePopup(jobId) {
       var screenWidth = window.screen.width;
       var screenHeight = window.screen.height;
       var popupWidth = 800;
       var popupHeight = 500;

       var leftPosition = (screenWidth - popupWidth) / 2;
       var topPosition = (screenHeight - popupHeight) / 2;

       var popup = window.open("edit_completion.php?id=" + jobId, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

       if (popup) {
           popup.focus();
       } else {
           alert('Please allow pop-ups to enter the date.');
       }
   }
</script>
<script>
    function exportData() {
        // Get the start and end date values
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;
    
   
        // Create the export URL with query parameters
        var exportUrl = 'exportclose_job.php';

        if (startDate && endDate) {
            exportUrl += '?start_date=' + encodeURIComponent(startDate) + '&end_date=' + encodeURIComponent(endDate);
        } else if (startDate) {
            exportUrl += '?start_date=' + encodeURIComponent(startDate);
        } else if (endDate) {
            exportUrl += '?end_date=' + encodeURIComponent(endDate);
        }

        // Redirect to the export URL
        window.location.href = exportUrl;
    }
</script>
   <?php
include('footer.php');
   ?>
   <?php } ?>