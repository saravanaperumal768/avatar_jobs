


<?php
include('top.php');
// include('connection.php');
$job_submit=1;
// / Check if the form is submitted
$success = false;
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
        $profile_picture = $row['profile_picture'];
        
        // Output the name
        // echo $name_member;
        // die;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Assuming you have a database connection in $db
    date_default_timezone_set('Asia/Kolkata');
    // Retrieve form data
    // $selectedMember = $_POST['member_complete'];
    $jobStatus = $_POST['job_status'];
    $close_time= date('Y-m-d H:i:s');
    $recordId = $_POST['record_id']; 
    $filelink= $_POST['filelink'];
    $cus_date=date("Y-m-d");
    
    // echo $selectedMember ;
    // echo $jobStatus ;
    // echo $close_time ;
    // echo $filelink ;
    // die;

    
    // echo 111;
    // exit;
    if (isset($_POST['submit']) ) {
        $query = "UPDATE jobcreate SET job_status = '$jobStatus', close_time = '$close_time', cus_date = '$cus_date' WHERE id = $recordId";
        $stmt = mysqli_query($db, $query);
        $message4 = "Job Closed Successfully";
        echo "<script type='text/javascript'>alert('$message4');</script>";
    }
   
  
   
}
// else{
//     echo"Submit Form Properly";
// }


?>
<style>
 table.dataTable tbody td, table.dataTable tbody th {
    padding: 5px 10px;
}   
.iq-footer{
    margin-left: 0px;
    width: 100%;
}
</style>
<div class="row" style="margin:5px 10px;">
    <div class="col-lg-4">
    <a href="job_submission.php">
<button type="button" class="btn btn-primary"  > <i class="fa fa-arrows-h"></i>&nbsp; Back</button>
    </a>
    </div>
    <div class="col-lg-6">
    <?php if (!empty($profile_picture)) { ?>
                                        <img src="<?php echo $profile_picture; ?>" style="width:50px; border-radius:50%;" class="img-fluid avatar-rounded" alt="<?php echo $name_member; ?>">
                                    <?php } else { ?> 
                                        <img src="members_img/noimg.jpg" style="width:50px; border-radius:50%;" class="img-fluid avatar-rounded" alt="Staff">
                                    <?php } ?>
                                     <!-- <img src="" class="img-fluid avatar-rounded" alt="Manikandan "> -->
                                    

                                      <span class="mb-0 ml-2 user-name" style="text-transform:uppercase;"><?php echo $name_member; ?> </span>
</div>
</div>
<div style="padding:10px;">
                    <table class="table data-table mb-0" >
                                        <thead class="table-color-heading">
                                            <tr class="">
                                                <!-- <th scope="col" class="pr-0 w-01">
                                                    <div class="d-flex justify-content-start align-items-end mb-1 ">
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input m-0" id="customChecked">
                                                            <label class="custom-control-label" for="customChecked"></label>
                                                        </div>
                                                    </div>
                                                </th> -->
                                
                              
                                       
                                       <th scope="col" style="width:25%;">Client Name/ Name of the Job /Job Type <br>/D.O.C </th>
                                
                                  
                                    <th scope="col" style="width:10%;">Reference </th>
                              
                                    <!-- <th>Enter Time</th> -->
                                    <th scope="col" style="width:10%;">Assigned By</th>
                                    <th scope="col">Notes</th>

                                    <th scope="col">
                           
                                  </th>
                                   
                                                <!-- <th scope="col" class="text-right"> 
                                                    Action
                                                </th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                  
                                    $start_date1=$_GET['start_date1'];
                                    $end_date1=$_GET['end_date1'];

                                 
                                    $sql2 = "SELECT * FROM jobcreate WHERE job_status='' AND members = '$name_member_id' and completion BETWEEN '$start_date1' AND '$end_date1' ORDER BY completion ASC, start_time ASC";

                                    $result2=mysqli_query($db,$sql2);
                                    if (mysqli_num_rows($result2) > 0) {
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {

                                        $twentyFourHourTime_start = $db_field2["start_time"];
                                        $twelveHourTime_starttime = date("h:i A", strtotime($twentyFourHourTime_start));

                                        $twentyFourHourTime_end = $db_field2["time_comp"];
                                        $twelveHourTime_endtime = date("h:i A", strtotime($twentyFourHourTime_end));

                                        $members_id_no =$db_field2["members"];
                                        $time_comp = $db_field2['time_comp']; 
                                        $fileLinks = explode("\n", $db_field2["reference"]);
                                             // Check for completion date nearing today's date
                                    $completionDate = strtotime($db_field2['completion']); // Convert completion date to a timestamp
                                   
                                    $today = strtotime(date('Y-m-d')); // Today's date as a timestamp

                                    // Calculate the difference in days
                                    $dateDifference = floor(($completionDate - $today) / (60 * 60 * 24));
                                        
                                        ?>  
                                        
                                            <tr class="white-space-no-wrap">
                                            <form method="POST">
                                            <!-- <td class="pr-0 ">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    
                                                    <input type="checkbox" class="custom-control-input m-0" id="customCheck<?php echo $db_field2["id"] ?>" value="<?php echo $db_field2["id"] ?>">
                                                    <label class="custom-control-label" for="customCheck<?php echo $db_field2["id"] ?>"></label>
                                                </div>
                                            </td> -->
                                                <!-- <td><?php echo $db_field2["clientname"]?></td> -->
                                                <td> 
                                                <?php
                                                if (!empty($db_field2["start_time"]) && !empty($db_field2["time_comp"])) {
                                                    // Convert start time to 12-hour format
                                                    $twelveHourTime_starttime = date("h:i A", strtotime($db_field2["start_time"]));

                                                    // Convert end time to 12-hour format
                                                    $twelveHourTime_endtime = date("h:i A", strtotime($db_field2["time_comp"]));

                                                    if ($dateDifference < 0) {
                                                        // Past date
                                                        echo '<span style="color: red;">'. $db_field2['clientname'] . '/&nbsp;'  . $db_field2['job'] . '/&nbsp;' . $db_field2['job_type'] .'<br>' . $db_field2['completion'] . '/&nbsp;' .  $twelveHourTime_starttime .' - '  . $twelveHourTime_endtime. '</span>';
                                                    } elseif ($dateDifference == 0) {
                                                        // Today's date
                                                        echo '<span style="color: red;">'. $db_field2['clientname'] . '/&nbsp;'  . $db_field2['job'] . '/&nbsp;' . $db_field2['job_type'] .'<br>' . $db_field2['completion'] . '/&nbsp;'.  $twelveHourTime_starttime .' - ' . $twelveHourTime_endtime. '</span>';
                                                    } else {
                                                        // Future date
                                                        echo $db_field2['clientname'] . '/&nbsp;'  . $db_field2['job'] . '/&nbsp;' . $db_field2['job_type'] . '/&nbsp;' . $db_field2['completion'] . '<br>' .  $twelveHourTime_starttime . ' - ' . $twelveHourTime_endtime;
                                                    }
                                                } else {
                                                    if ($dateDifference < 0) {
                                                        // Past date
                                                         echo '<span style="color: red;">'. $db_field2['clientname'] . '/&nbsp;'  . $db_field2['job'] . '/&nbsp;' . $db_field2['job_type'] . '<br>' . $db_field2['completion'] . '/&nbsp;' . ' Time Not Mentioned </span>' ;
                                                    } elseif ($dateDifference == 0) {
                                                        // Today's date
                                                        echo '<span style="color: red;">'. $db_field2['clientname'] . '/&nbsp;'  . $db_field2['job'] . '/&nbsp;' . $db_field2['job_type'] . '<br>' . $db_field2['completion'] . '/&nbsp;' . ' TIme Not Mentioned </span>' ;
                                                    } else {
                                                        // Future date
                                                        echo  $db_field2['clientname'] . '/&nbsp;'  . $db_field2['job'] . '/&nbsp;' . $db_field2['job_type'] . '/&nbsp;' . $db_field2['completion'] . '/&nbsp;' . ' TIme Not Mentioned ' ;
                                                    }
                                                }
                                                ?>

                                                </td>

                                                <!-- <td class="">
                                                    <div class="active-project-1 d-flex align-items-center mt-0 ">
                                                        <div class="h-avatar is-medium">
                                                            <?php
                                                        $members_name_query = "SELECT * FROM members WHERE id='$members_id_no'";
                                                                $result_members = mysqli_query($db, $members_name_query);

                                                                if ($result_members) {
                                                                    $member_data = mysqli_fetch_assoc($result_members);

                                                                    if ($member_data) {
                                                                        
                                                                        
                                                                        $profile_picture = $member_data['profile_picture'];
                                                                        
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
                                                                        
                                                                        $member_name = $member_data['fname'];
                                                                        $lname = $member_data['lname'];
                                                                        
                                                                        echo '<div>';
                                                                        echo '<span class="font-weight-bold">' . $member_name . ' ' . $lname . '</span>';
                                                                        echo '</div>';
                                                                    } else {
                                                                        echo "No member found with that ID.";
                                                                    }
                                                                } else {
                                                                    echo "Error executing the query: " . mysqli_error($db);
                                                                }
                                                                ?></span>                           
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                </td> -->
                                                <td>
                                        <?php if (empty($db_field2["reference"]) && empty($db_field2["reference_link"])) { ?>
                                            <p style="color:red;">No Data</p>
                                            <?php } elseif(!empty($db_field2["reference"]) && !empty($db_field2["reference_link"])) { ?>
                                                 <a href="<?php echo $db_field2["reference_link"]; ?>" target="_blank">Reference Link</a> /<br>
                                                 <?php
                                                // $count = 1; 
                                                foreach ($fileLinks as $fileLink) { ?>
                                                 <a href="<?php echo $fileLink; ?>" target="_blank">Reference</a><br>
                                                 <?php
                                    //  $count++;

                                             }  ?>
                                        <?php } else {      if (empty($db_field2["reference"])) {?>
                                            <a href="<?php echo $db_field2["reference_link"]; ?>" target="_blank">Reference Link</a>
                                            <?php } else {
                                                // $count = 1; 
                                                foreach ($fileLinks as $fileLink) { ?>
                                             <a href="<?php echo $fileLink; ?>" target="_blank">File Link 
                                             <!-- <?php echo $count; ?> -->
                                            </a><br>
                                        <?php
                                    // $count++;

                                    } } }  ?>
                                           
                                    </td>
                                       

                                     <td class>   
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
                                            if (empty($db_field2["notes"])) {
                                                ?> 
                                                <p style="color:red;"> No Data </p>
                                            <?php } else {
                                                $notes = $db_field2["notes"];
                                                $words = explode(' ', $notes);

                                                $currentLength = 0;
                                                $maxRowLength = 40;

                                                foreach ($words as $word) {
                                                    if ($currentLength + strlen($word) <= $maxRowLength) {
                                                        echo $word . ' ';
                                                        $currentLength += strlen($word) + 1; // 1 is for space between words
                                                    } else {
                                                        echo '<br>' . $word . ' ';
                                                        $currentLength = strlen($word) + 1;
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>


                                    <td style="display:none;"> <input type="hidden" name="record_id" value="<?php echo $db_field2["id"]?>"></td>
                                       <td style="display:none;"><input type="hidden" id="" name="time_picker" value="<?php echo date('H:i');?>"></td>
                                    <td style="display:none;">
                                        <?php
                                          $recordId = $db_field2["id"];
                                          $sqlUpdated = "SELECT * FROM jobcreate WHERE id = '$recordId'";
                                                    $resultUpdated = mysqli_query($db, $sqlUpdated);

                                                    while ($row = mysqli_fetch_assoc($resultUpdated)) {
                                                        $selectedMember = $row['member_complete'];
                                                        $filelink = $row['filelink'];
                                                        

                                                     if (empty($filelink) ) { ?>
                                        <input type="text" id="" class="select_member " name="filelink" >
                                        <?php } else { ?>
                                            <!-- <input type="text" id="filelink" name="filelink" onClick="copyToClipboard()" value="<?php echo $filelink; ?>"> -->
                                            <div class="clipboard">
                                            
                                            <input class="copy-input" value="<?php echo htmlspecialchars($filelink); ?>" id="copyClipboard" >
                                            <button class="copy-btn" onclick="copyToClipboard('<?php echo ($filelink); ?>')"><i class="fa fa-copy"></i></button>
                                            </div>
                                                        <?php }
                                                    } ?>
                                                     <!-- <input type="text" id="" name="filelink"> -->
                                    </td>                                       
                  
                       
                                        </form>

                                            
                                            </tr>
                                            <?php } } else{?>
                                                <tr>
                                                <td>
                                                <p style="color:red;text-align:center;">No Records Found </p>
                                             </td>
                                            </tr>
                                               <?php }?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                    <?php
include('footer.php');
    ?>