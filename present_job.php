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
       $name_member2 = $row['fname'];
       $name_member_id = $row['id'];
       
       // Output the name
       // echo $name_member;
       // die;
   }
}



include('top.php');

$present_job=1;

?>


<?php
include('left.php');
include('nav.php');
?>  
      
      <div class="content-page">
    <div class="shell">
        <div class="container">
            <div class="row">
                <?php
                date_default_timezone_set('Asia/Kolkata');
                $curtime = date('H:i'); // Get the current time in the format 'HH:MM'
               
                $cur_date= date('Y-m-d');
                 $hours = intval($curtime); 
                $rounded_hours = round($hours); 
               
                $rounded_time = sprintf("%02d.00", $rounded_hours);
                 $end_time = date('H:i', strtotime('+4 hour', strtotime($curtime))); // Add 1 hour to the current time
                // echo $end_time;
                // exit;
                
               $sql_all_members = "SELECT * FROM members WHERE status='1'";
                $result_all_members = mysqli_query($db, $sql_all_members);

                if ($result_all_members) {
                    while ($row_member = mysqli_fetch_assoc($result_all_members)) {
                        $member_id = $row_member['id'];
                        $member_name = $row_member['fname'] . " " . $row_member['lname'];

                       
                      $sql_jobs_for_member = "
                        SELECT * 
                        FROM jobcreate 
                        WHERE
                            completion = '$cur_date' 
                            AND (
                                (time_comp BETWEEN '$curtime' AND '$end_time') 
                                OR (start_time BETWEEN '$rounded_time' AND '$end_time')
                            )
                            AND members = '$member_id' 
                        LIMIT 1";
                        // echo $sql_jobs_for_member;
                        // exit;
                        
                        $result_jobs_for_member = mysqli_query($db, $sql_jobs_for_member);

                        if ($result_jobs_for_member) {
                            $num_rows_jobs_for_member = mysqli_num_rows($result_jobs_for_member);
                            if ($num_rows_jobs_for_member > 0) {
                                // If jobs are found for the member, display the job details
                                while ($db_field2 = mysqli_fetch_array($result_jobs_for_member)) {
                                    $time_comp = $db_field2["time_comp"];
                                    $fileLinks = explode("\n", $db_field2["reference"]);
                                    $completionDate = strtotime($db_field2['completion']); // Convert completion date to a timestamp
                                    $today = strtotime(date('Y-m-d')); // Today's date as a timestamp
                                    $dateDifference = floor(($completionDate - $today) / (60 * 60 * 24)); // Calculate the difference in days
                                    ?>
                                    <div class="col-md-3">
                                        <div class="wsk-cp-product">
                                            <div class="wsk-cp-img">
                                                <?php
                                                $profile_picture = $row_member['profile_picture'];
                                                ?>
                                                <img src="<?php echo $profile_picture ?>" alt="AGS" class="img-responsive" />
                                            </div>
                                            <div class="wsk-cp-text">
                                                <div class="category">
                                                    <span><?php echo $member_name; ?></span>
                                                </div>
                                                <div class="title-product">
                                                    <h6><?php echo $db_field2['start_time']; ?> - <?php echo $db_field2['time_comp']; ?> </h6>
                                                    <h3><?php echo $db_field2['completion']; ?></h3>
                                                </div>
                                                <div class="description-prod">
                                                    <ul>
                                                        <li><?php echo $db_field2['clientname']; ?></li>
                                                        <li><?php echo $db_field2['job']; ?></li>
                                                        <li><?php echo $db_field2['job_type']; ?></li>
                                                        <li><?php echo $db_field2['assigned_by']; ?></li>
                                                    </ul>
                                                </div>
                                                <div class="card-footer" style="text-align:center;">
                                                    <div class=""><span class="price" style="color:red;">Working On</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                // If no jobs are found for the member, display a message
                                ?>
                                <div class="col-md-3">
                                    <div class="wsk-cp-product">
                                        <div class="wsk-cp-img">
                                            <?php
                                            $profile_picture = $row_member['profile_picture'];
                                            ?>
                                            <img src="<?php echo $profile_picture ?>" alt="Product" class="img-responsive" />
                                        </div>
                                        <div class="wsk-cp-text">
                                            <div class="category">
                                                <span><?php echo $member_name; ?></span>
                                            </div>
                                            <div class="title-product">
                                                <p>No work assigned to this member</p>
                                            </div>
                                            <div class="card-footer" style="text-align:center;">
                                                <div class=""><span class="price" style="color:red;">Free</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            // If there's an error in the query for the member, display an error message
                            echo "Error executing SQL query for $member_name: " . mysqli_error($db) . "<br>";
                        }
                    }
                } else {
                    // If there's an error in fetching all members, display an error message
                    echo "Error fetching all members: " . mysqli_error($db) . "<br>";
                }
                ?>
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

   function openmemberpopup(jobId) {
       var screenWidth = window.screen.width;
       var screenHeight = window.screen.height;
       var popupWidth = 800;
       var popupHeight = 500;

       var leftPosition = (screenWidth - popupWidth) / 2;
       var topPosition = (screenHeight - popupHeight) / 2;
       var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

   var popup = window.open("edit_members.php?id=" + jobId + "&logname=" + logName, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

       if (popup) {
           popup.focus();
       } else {
           alert('Please allow pop-ups to enter the date.');
       }
   }

   function openreferencepopup(jobId) {
       var screenWidth = window.screen.width;
       var screenHeight = window.screen.height;
       var popupWidth = 800;
       var popupHeight = 500;

       var leftPosition = (screenWidth - popupWidth) / 2;
       var topPosition = (screenHeight - popupHeight) / 2;
       var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

   var popup = window.open("edit_reference.php?id=" + jobId, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

       if (popup) {
           popup.focus();
       } else {
           alert('Please allow pop-ups to enter the date.');
       }
   }

   function openmemberpopup(jobId) {
       var screenWidth = window.screen.width;
       var screenHeight = window.screen.height;
       var popupWidth = 800;
       var popupHeight = 500;

       var leftPosition = (screenWidth - popupWidth) / 2;
       var topPosition = (screenHeight - popupHeight) / 2;
       var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

   var popup = window.open("member_created.php?id=" + jobId + "&logname=" + logName, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

       if (popup) {
           popup.focus();
       } else {
           alert('Please allow pop-ups to enter the date.');
       }
   }
</script>

   <?php
include('footer.php');
   ?>
   <?php } ?>