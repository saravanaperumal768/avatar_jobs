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

$meetings=1;  

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

$create=1;

if ($_POST["Submit"]=="Add"){
    
    $meetingname = mysqli_real_escape_string($db, $_POST['meetingname']);
    $meeting_date = mysqli_real_escape_string($db, $_POST['meeting_date']);
    $start_time = mysqli_real_escape_string($db, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($db, $_POST['end_time']);
    $client_name = mysqli_real_escape_string($db, $_POST['client_name']);
    $notes = mysqli_real_escape_string($db, $_POST['notes']);
    $members_name = isset($_POST['members_name']) ? implode(',', $_POST['members_name']) : '';
    
    $sql = "INSERT INTO meeting (meetingname, meeting_date, start_time, end_time, client_name, notes, members_name) 
            VALUES ('$meetingname', '$meeting_date', '$start_time', '$end_time', '$client_name', '$notes', '$members_name')";
    // echo $sql;
    // exit;
    if(mysqli_query($db, $sql)){
        echo "<script>alert('Meeting added successfully!');</script>";
    } else{
        echo "<script>alert('Error: " . mysqli_error($db) . "');</script>";
    }
    
  
  }

  if ($_POST["Submit"] == "Update") {
    // Construct the update query
    $id = mysqli_real_escape_string($db, $_POST['id1']);
    $meetingname = mysqli_real_escape_string($db, $_POST['meetingname']);
    $meeting_date = mysqli_real_escape_string($db, $_POST['meeting_date']);
    $start_time = mysqli_real_escape_string($db, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($db, $_POST['end_time']);
    $client_name = mysqli_real_escape_string($db, $_POST['client_name']);
    $notes = mysqli_real_escape_string($db, $_POST['notes']);
    $members_name = isset($_POST['members_name']) ? implode(',', $_POST['members_name']) : '';
    
    // Update query
    $sql = "UPDATE meeting SET 
                meetingname = '$meetingname', 
                meeting_date = '$meeting_date', 
                start_time = '$start_time', 
                end_time = '$end_time', 
                client_name = '$client_name', 
                notes = '$notes', 
                members_name = '$members_name'
            WHERE id = '$id'";
    // echo $sql;
    // exit;
    // Execute the query
    if (!mysqli_query($db, $sql)) {
        die('Error: ' . mysqli_error($db));
    } else {
       
    }
}

		 
 ?>
 
 
 <?php
include('left.php');
include('nav.php');
 ?>  

 <style>
input#timeInput {
    width: 60%;
    margin: 7px;
    padding: 7px;
}
textarea .form-control  {
    height: 46px;
    line-height: 29px;
    background: #fff;
    border: 1px solid #f1f1f1;
    font-size: 14px;
    color: #324253;
    border-radius: 5px;
    box-shadow: none;
}
@media(max-width:991px){
    input#timeInput {
    width: 70%;
    margin: 7px;
    padding: 7px;
}
}
</style>
<script type="text/javascript" src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script> 
      <div class="content-page">
<div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-12">
                     
                <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Assign Meetings</h4>
                     </div>
                  <div class="header-action">
                           <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false">
                              <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                              </svg>
                           </i>
                        </div>
                  </div>

                  <form action="meetings.php"  method="post" enctype="multipart/form-data" id="add_product" onSubmit="return validate();">  
                  <div class="card-body">
                  <!-- action="iteration_data.php" method="POST" -->
                     <form   method="post">

                     <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
                        <div class="row"> 
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Meeting Name </label>
                                    <input type="text" class="form-control" id="exampleInputText1" name="meetingname" value="<?php echo $_REQUEST["meetingname"]; ?>" placeholder="Name Of Meeting">
                                    </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Assigned To</label>
                                    <div class="row">
                                    <?php
$category2 = mysqli_query($db, "SELECT * FROM members WHERE status='1'");
$selected_members = isset($_REQUEST['members_name']) ? (is_array($_REQUEST['members_name']) ? $_REQUEST['members_name'] : explode(',', $_REQUEST['members_name'])) : array();

$selected_member_names = array(); // Initialize an empty array to hold the selected member names

while ($cat2 = mysqli_fetch_array($category2)) {
    $checked = in_array($cat2['id'], $selected_members) ? 'checked' : '';
    if ($checked) {
        $selected_member_names[] = $cat2['fname']; // Add the selected member name to the array
    }
    ?>
    <div class="col-md-4 col-lg-4">
        <div class="input_field select_option">
            <input type="checkbox" id="<?php echo $cat2['id'] ?>" name="members_name[]" value="<?php echo $cat2['id'] ?>" <?php echo $checked; ?>>
            <label for="<?php echo $cat2['id'] ?>"> <?php echo $cat2['fname'] ?></label><br>
        </div>
    </div>
<?php } 

// Print the selected member names
if (!empty($selected_member_names)) {
    echo '<div>Selected Members: ' . implode(', ', $selected_member_names) . '</div>';
}
?>




                                    </div>
                                </div>
                            </div>

                            </div>
                        </div>
                        <div class="row" style="margin:10px;"> 
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputText1">Day of the Week</label>
                                <select class="form-control" id="meeting_date" name="meeting_date">
                                    <option value="Monday" <?php if($_REQUEST["meeting_date"] == "Monday") echo "selected"; ?>>Monday</option>
                                    <option value="Tuesday" <?php if($_REQUEST["meeting_date"] == "Tuesday") echo "selected"; ?>>Tuesday</option>
                                    <option value="Wednesday" <?php if($_REQUEST["meeting_date"] == "Wednesday") echo "selected"; ?>>Wednesday</option>
                                    <option value="Thursday" <?php if($_REQUEST["meeting_date"] == "Thursday") echo "selected"; ?>>Thursday</option>
                                    <option value="Friday" <?php if($_REQUEST["meeting_date"] == "Friday") echo "selected"; ?>>Friday</option>
                                    <option value="Saturday" <?php if($_REQUEST["meeting_date"] == "Saturday") echo "selected"; ?>>Saturday</option>
                                    <option value="Sunday" <?php if($_REQUEST["meeting_date"] == "Sunday") echo "selected"; ?>>Sunday</option>
                                </select>
                            </div>
                        </div>
                            
                                      <div class="col-md-3 col-lg-3">
                                            <label> Start Time </label> 
                                            
                                            
                                            <div class="input_field "> 
                                            
                                            <input type="time" id="timeInput" name="start_time" min="9:00" max="19:00" value="<?php echo $_REQUEST["start_time"];?>" >
                                            <span class="validity"></span>

                                            </div>
                                        </div>

                                        <div class="col-md-3 col-lg-3">
                                            <label> End Time </label> 
                                    
                                            <div class="input_field "> 
                                            
                                            <input type="time" id="timeInput" name="end_time"  min="9:00" max="19:00" value="<?php echo $_REQUEST["end_time"];?>" >
                                            <span class="validity"></span>
                                            </div>
                                        </div>
                                        
                                        
                            </div>
                            <div class="row"style="margin:10px;">
                            <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                           <label for="exampleInputPassword4">Select Clients</label>
                           <div class="input_field select_option">
                                
                           <select name="client_name" id="membersSelect">
                            <?php
                            $category2 = mysqli_query($db, "SELECT * FROM clients");

                            while ($cat2 = mysqli_fetch_array($category2)) {
                                $selected = ($_REQUEST["client_name"] == $cat2['name']) ? 'selected' : '';
                               
                            ?>
                                <option value="<?php echo $cat2['name'] ?>" <?php echo $selected ?>><?php echo $cat2['name'] ?></option>
                            <?php } ?>
                        </select>

                                <!-- <input type="text" name="memberIdHidden" id="memberIdHidden" value=""> -->
                            <div class="select_arrow"></div>
                            
                          </div>
                        </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputNumber3">Notes</label>
                                            <textarea class="form-control" id="editor1"  style="border: 1px solid #0003;" id="exampleFormControlTextarea1" name="notes" rows="1"><?php echo $_REQUEST["notes"];?></textarea>
                                            <script type="text/javascript">
                                  var editor = CKEDITOR.replace( 'editor1' );

                                // The "change" event is fired whenever a change is made in the editor.
                                editor.on( 'change', function( evt ) {
                                    // getData() returns CKEditor's HTML content.
                                  console.log( 'This is what you typed ' + evt.editor.getData() + typeof evt.editor.getData() );
                                    console.log( 'Total bytes: ' + evt.editor.getData().length );
                                  $('#hiddedn input').val(evt.editor.getData());
                                });
                                </script>
                                            </div>
                                         </div>  
                            </div>
                            <div class="form-group">
						<label class="col-xs-12 " style="text-align:center;"><input name="Submit22" type="reset" class="btn btn-danger" value="Back"  onclick="location.replace('meetings.php')" />
                                                      <?php if($_REQUEST["bid"]=="up")
                                                   
 {?>
 
                                                   
    <input name="Submit" type="submit" class="btn btn-danger" id="Submit" value="Update" />


                                                      <?php
							}
							 else if($_REQUEST["bid"]=="del")
							 {
							?>
                                                      <input name="Submit" type="submit" class="btn btn-danger" id="Submit" value="Delete" />
                                                      <?php 
							} 
			 				 else if($_REQUEST["bid"]=="sav") 
			 				{
							 ?>
                                                      <input name="Submit" type="submit" class="btn btn-danger" id="Submit2" value="Add" />
                                                      <?php 
							}
							else
							{
							?>
                                                      <input name="Submit2" type="reset" class="btn btn-danger" value="Add New" onClick="location.replace('meetings.php?bid=sav')" />
                                                      <?php 
							
							} 
 

 
 ?>
                                                      <input name="Submit" type="reset" class="btn btn-danger" value="Reset" onClick="location.replace('meetings.php?bid=sav')" /></label></div>
						
						</div>
                            <!-- <button type="submit" class="btn btn-danger">Edit</button>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        
                     </form>
                  </div>

                  <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Meeting List</h5>
                              
                                </div>
                                <div class="table-responsive ">

                                    <!-- <div class="" style="margin: 0px 18px;">
                                    <button type="button" class="btn btn-danger" id="iteration_deleteSelected" style="background:red;"> <i class="fa fa-trash-o"></i>&nbsp; Delete Selected</button>
                                    </div> -->

                             
                                    <table class="table data-table mb-0 " >
                                    
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
                                                <th scope="col">Name of the Meeting   </th>
                                                <th scope="col">Client Name   </th>
                                                <th scope="col">Day of the Week   </th>
                                                <th scope="col">Start Time  </th>
                                                <th scope="col">End Time  </th>
                                                <th scope="col">Staffs   </th>
                                                <th scope="col">Notes </th>
                                                
                                 
                                                <th scope="col" > 
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                //   WHERE members = '$name_member_id'
                              
                                $sql2 = "SELECT * FROM meeting ORDER BY id ASC";


                                //   echo $sql2;
                                //   exit;
                                    $result2=mysqli_query($db,$sql2);
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {
                                       $id =$db_field2["id"];
                                       $client_name = $db_field2["client_name"];
                                       $members_name = $db_field2["members_name"];
                                       $meeting_date = $db_field2["meeting_date"];
                                       $start_time = $db_field2["start_time"];
                                       $end_time = $db_field2["end_time"];
                                       	$meetingname = $db_field2["meetingname"];
                                       $notes = $db_field2["notes"];
                                    
                                        ?>  
                           
                                            <tr class="white-space-no-wrap">
                                            <!-- <td class="pr-0 ">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                   
                                                    <input type="checkbox" class="custom-control-input m-0" id="customCheck<?php echo $db_field2["id"] ?>" value="<?php echo $db_field2["id"] ?>">
                                                    <label class="custom-control-label" for="customCheck<?php echo $db_field2["id"] ?>"></label>
                                                </div>
                                            </td> -->
                                            <!-- <td><?php echo $db_field2["id"] ?> </td> -->

                                            
                                            <!-- <input name="img" type="hidden" id="img" value="<?php echo $_REQUEST["id"]; ?>" /> -->
                                                
                                         <td><?php echo $db_field2["meetingname"] ?> </td>
                                         <td><?php echo $db_field2["client_name"] ?> </td>
                                         <td><?php echo $db_field2["meeting_date"] ?> </td>
                                         <td><?php echo $db_field2["start_time"] ?> </td>
                                         <td><?php echo $db_field2["end_time"] ?> </td>
                                         <td>
                                         <?php 
                                            $members_name_query = "SELECT * FROM members WHERE id='$members_name'";
                                            $result_members = mysqli_query($db, $members_name_query);

                                            if ($result_members) {
                                                $db_field2 = mysqli_fetch_assoc($result_members);
                                                $fileLinks = explode(',', $members_name); // Assuming member IDs are comma-separated
                                                
                                                foreach ($fileLinks as $member_id) { 
                                                    // Fetch the member's data based on the member_id
                                                    $query = "SELECT fname, lname FROM members WHERE id = '$member_id'";
                                                    $result = mysqli_query($db, $query);
                                                
                                                    if ($row = mysqli_fetch_assoc($result)) {
                                                        $fname = $row['fname'];
                                                        $lname = $row['lname'];
                                                
                                                        // Display the member's name
                                                        echo '<div>';
                                                        echo '<span class="font-weight-bold">' . $fname . ' ' . $lname . '</span><br>';
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                            ?>

                                        
                                        </td>
                                        
                                        <td><?php echo $notes ?> </td>
                                         <!-- <td><?php echo $db_field2["end_time"] ?> </td> -->
                                         
                                                                                     
                                               <td>
                                                    <div class="d-flex align-items-center">
                                                         <!-- <a class="" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="customer-view.html">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a> -->
                                                        <?php
                                                        echo "<a href='meetings.php?bid=up&id=$id&client_name=$client_name&members_name=$members_name&meeting_date=$meeting_date&start_time=$start_time&end_time=$end_time&meetingname=$meetingname&notes=$notes' target='_parent'>";
                                                        ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                        <?php echo "</a>" ?>
                                                      <form action="meetingsdelete_job.php" method="post">
                                                        <input type="hidden" name="job_id" value="<?php echo $id; ?>">
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
                                    </form>
               </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      </div>
    </div>
    


    <?php
include('footer.php');
    ?>
    <?php } ?>