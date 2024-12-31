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

$complete=1;

?>


<?php
include('left.php');
include('nav.php');
?>  
      
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
                                   <a href="export_complete.php" style="display:none;">
                                       <button class="btn btn-secondary btn-sm">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                           </svg>
                                           Export
                                       </button>
                                   </a>
                               </div>
                               
                               <div class="table-responsive">
                                 
                                   <table class="table  mb-0">
                                   <div class="row" style="margin: 10px 18px;">
                                  
                                   <form method="POST">
                                       <div class="col-lg-4 col-md-4 mr_5">
                                           <label class="filter_assigned_label">Filter By Staff:</label>
                                           <select id="assignedToFilter" name="assignedToFilter" class="filter_assigned">
                                               <option value="0">Select Staff</option>
                                               <?php
                                               $category2 = mysqli_query($db, "SELECT * FROM members");
                                               while ($cat2 = mysqli_fetch_array($category2)) {
                                               ?>
                                                   <option value="<?php echo $cat2['id']; ?>" <?php if (isset($_POST['assignedToFilter']) && $_POST['assignedToFilter'] == $cat2['id']) echo 'selected'; ?>>
                                                       <?php echo $cat2['fname']; ?>
                                                   </option>
                                               <?php } ?>
                                           </select>
                                       </div>

                                       <div class="col-lg-5 col-md-5 mr_5">
                                           <label class="filter_assigned_label">Filter by Client:</label>
                                           <select id="clientnameFilter" name="clientnameFilter" class="filter_assigned">
                                               <option value="0">Select Client</option>
                                               <?php
                                               $category2 = mysqli_query($db, "SELECT * FROM clients WHERE status='1'");
                                               while ($cat2 = mysqli_fetch_array($category2)) {
                                               ?>
                                                   <option value="<?php echo $cat2['name']; ?>" <?php if (isset($_POST['clientnameFilter']) && $_POST['clientnameFilter'] == $cat2['name']) echo 'selected'; ?>>
                                                       <?php echo $cat2['name']; ?>
                                                   </option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                       <div class="col-lg-3 col-md-3" style="margin-top:20px;">
                                           <button type="submit" class="btn btn-primary">Filter</button>
                                           <button type="button" class="btn btn-secondary" onclick="resetPage()">Reset</button>
                                       </div>
                                   </form>
                                                                       

                                   </div>
                                       <thead class="table-color-heading">
                                           <tr class="">
                                    
                                   <th scope="col">Client Name</th>
                                   <th scope="col" >Name of the Job / <br> Date & Time <br>Of Completion  </th>
                                   <th scope="col">Assigned To </th>
                                   
                              
                                   <th scope="col">Job File</th>
                                   <th scope="col">File Link</th>
                                   <th scope="col" style="display:none">Job Status</th>
                                   <th scope="col">Time Taken </th>
                               
                                               <th scope="col" class="text-right" style="display:none"> 
                                                   Action
                                               </th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                       <?php
                               //   WHERE members = '$name_member_id'
                               $assignedToFilter = isset($_POST['assignedToFilter']) ? $_POST['assignedToFilter'] : 0;
                               $clientnameFilter = isset($_POST['clientnameFilter']) ? $_POST['clientnameFilter'] : '0';
                       
                               $sql2 = "SELECT * FROM jobcreate WHERE job_status <>'' AND completion >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
                               
                               if ($assignedToFilter != 0) {
                                   $sql2 .= " AND members = '$assignedToFilter'";
                               }
                               
                               if ($clientnameFilter != '0') {
                                   $sql2 .= " AND clientname = '$clientnameFilter'";
                               }
                       
                               $sql2 .= " ORDER BY completion DESC";
                      


                               //   echo $sql2;
                               //   exit;
                                   $result2=mysqli_query($db,$sql2);
                                   $num=1;
                                   while ($db_field2 = mysqli_fetch_array($result2)) {
                                      $members_id_no =$db_field2["members"];
                                           
                                                  // Check for completion date nearing today's date
                                   $completionDate = strtotime($db_field2['completion']); // Convert completion date to a timestamp
                                   $today = strtotime(date('Y-m-d')); // Today's date as a timestamp

                                   // Calculate the difference in days
                                   $dateDifference = floor(($completionDate - $today) / (60 * 60 * 24)); 
                                       ?>  
                                           <tr class="white-space-no-wrap">
                                 
                                               <td><?php echo $db_field2["clientname"]?></td>
                                               <td><?php echo $db_field2["job"]?> / <br>
                                               <?php
                                                   if ($dateDifference >= 0 && $dateDifference <= 1) {
                                                       echo '<span style="color: red;">' . $db_field2['completion'] . '</span>'; // Highlight in red
                                                   } else {
                                                       echo  $db_field2['completion']; // Normal display
                                                   }
                                                   ?> /<br>
                                                   <?php echo $db_field2["time_comp"]?> 
                                                 
                                               </td>
                                               <td class="">
                                                   <div class="active-project-1 d-flex align-items-center mt-0 ">
                                                       <div class="h-avatar is-medium">
                                                       <?php
                                                       $members_name_query = "SELECT * FROM members WHERE id='$members_id_no'";
                                                               $result_members = mysqli_query($db, $members_name_query);

                                                               if ($result_members) {
                                                                   $member_data = mysqli_fetch_assoc($result_members);

                                                                   if ($member_data) {
                                                                       // Assuming 'members' is a column in your 'members' table
                                                                       
                                                                       $profile_picture = $member_data['profile_picture'];
                                                                       // $lname = $member_data['lname'];
                                                                       if (!empty($profile_picture)) {
                                                                       ?>
                                                           <img class="avatar rounded-circle" alt="user-icon" src="<?php echo $profile_picture ?>">
                                                           <?php } else {?>
                                                               <img class="avatar rounded-circle" alt="user-icon" src="members_img/no_img.jpg">

                                                           <?php }}}?>
                                                       </div>
                                                       <div class="data-content">
                                                           <div>
                                                           <span class="font-weight-bold">

                                                           <?php
                                                       $members_name_query = "SELECT * FROM members WHERE id='$members_id_no'";
                                                       $result_members = mysqli_query($db, $members_name_query);

                                                       if ($result_members) {
                                                           $member_data = mysqli_fetch_assoc($result_members);

                                                           if ($member_data) {
                                                               // Assuming 'members' is a column in your 'members' table
                                                               $member_name = $member_data['fname'];
                                                               $lname = $member_data['lname'];
                                                               // Displaying the member's name within the <span> tag
                                                               echo '<div>';
                                                               echo '<span class="font-weight-bold">' . $member_name . ' ' . $lname . '</span>';
                                                               echo '</div>';
                                                           } else {
                                                               echo "No member found with that ID.";
                                                           }
                                                       } else {
                                                           echo "Error executing the query: " . mysqli_error($db);
                                                       }
                                                       ?>
                                                           </span>                           
                                                           </div>
                                                          
                                                       </div>
                                                   </div>
                                               </td>
                                              
                                               
                                      
                                               <!-- <td> 
                                                   <?php
                                                   if ($dateDifference >= 0 && $dateDifference <= 1) {
                                                       echo '<span style="color: red;">' . $db_field2['completion'] . '</span>'; // Highlight in red
                                                   } else {
                                                       echo  $db_field2['completion']; // Normal display
                                                   }
                                                   ?>
                                               </td>
                                      <td> <?php echo $db_field2["time_comp"]?>  </td> -->
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


                                   <td style="display:none">
                                       <?php
                                       if (empty($db_field2["job_status"])) {
                                           echo 'Still Open';
                                       } else {
                                           echo $db_field2["job_status"] . '<br>';
                                           echo date('Y-m-d h:i A', strtotime($db_field2["close_time"]));
                                       }
                                       ?>
                                   </td>



                                   

                                    <td>
                                       
                                    <?php 
                                    
                                        $start_time = $db_field2['job_start_at'];
                                       $close_time = $db_field2['close_time'];
                                       $job_pause_at = $db_field2['job_pause_at'];
                                       $job_start_again = $db_field2['job_start_again'];
                                   
                                       // Normal working intervals (start to pause or close)
                                       if (!empty($start_time)) {
                                           $startDateTime = new DateTime($start_time);
                                   
                                           if (!empty($job_pause_at)) {
                                               $pauseDateTime = new DateTime($job_pause_at);
                                               $interval = $startDateTime->diff($pauseDateTime);
                                           } else {
                                               $closeDateTime = new DateTime($close_time);
                                               $interval = $startDateTime->diff($closeDateTime);
                                           }
                                           $totalWorkingSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
                                       }
                                   
                                       // Paused intervals (pause to restart)
                                       if (!empty($job_pause_at) && !empty($job_start_again)) {
                                           $pauseDateTime = new DateTime($job_pause_at);
                                           $startAgainDateTime = new DateTime($job_start_again);
                                           $interval = $pauseDateTime->diff($startAgainDateTime);
                                           $totalPausedSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
                                       }
                                   
                                       // Additional working time after pause
                                       if (!empty($job_start_again) && !empty($close_time)) {
                                           $startAgainDateTime = new DateTime($job_start_again);
                                           $closeDateTime = new DateTime($close_time);
                                           $interval = $startAgainDateTime->diff($closeDateTime);
                                           $totalWorkingSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
                                       }

                                    $hours = $totalWorkingSeconds / 3600;

                                    // Format the hours to 2 decimal places
                                    $totalWorkingTime = sprintf("%.2f hrs", $hours);

                                       // Output the duration in hours
                                       echo  $totalWorkingTime  ;

                                    ?></td>                                              
                                              <td style="display:none">
                                                   <div class="d-flex align-items-center">
                                           
                                                       <form action="delete_job.php" method="post">
                                                       <input type="hidden" name="job_id" value="<?php echo $db_field2['id']; ?>">
                                                       <button type="submit" class="badge bg-danger" style="border:none;"  name="delete_job" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                           <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                           </svg>
                                                       </button>
                                                           </form>
                                                   </div>
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
function resetPage() {
   window.location.reload();
}
</script>
   <?php
include('footer.php');
   ?>
   <?php } ?>