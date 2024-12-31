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

$emergency_reminder=1;  

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
    // $id = mysqli_real_escape_string($db, $_POST['id1']);
    $emergencyname = mysqli_real_escape_string($db, $_POST['name']);
    $clientname = mysqli_real_escape_string($db, $_POST['clientname']);
    $members_name = mysqli_real_escape_string($db, $_POST['members_name']);
    $notes = mysqli_real_escape_string($db, $_POST['notes']);
  

    $sql = "INSERT INTO emergency_reminder (emergencyname, clientname, members_name, notes) VALUES ('" . mysqli_real_escape_string($db, $emergencyname) . "', '" . mysqli_real_escape_string($db, $clientname) . "', '" . mysqli_real_escape_string($db, $members_name) . "', '" . mysqli_real_escape_string($db, $notes) . "')";

    // echo($sql);
    // exit;
    if (!mysqli_query($db,$sql)){die('Error: ' . mysqli_error());}
  
  }

  if ($_POST["Submit"] == "Update") {
    // Construct the update query
    $id = mysqli_real_escape_string($db, $_POST['id1']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $members_name = mysqli_real_escape_string($db, $_POST['members_name']);
    $clientname = mysqli_real_escape_string($db, $_POST['clientname']);
    $clientname_end = mysqli_real_escape_string($db, $_POST['clientname_end']);
    $notes = mysqli_real_escape_string($db, $_POST['notes']);

    $sql = "UPDATE emergency_reminder SET 
            	emergencyname	= '$name',
            members_name = '$members_name',
            clientname = '$clientname',
            notes = '$notes'
            WHERE id = $id";
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
       
      <div class="content-page">
<div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-12">
                     
                <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Emergency Alert</h4>
                     </div>
                  <div class="header-action">
                           <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false">
                              <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                              </svg>
                           </i>
                        </div>
                  </div>

                  <form action="emergency_reminder.php"  method="post" enctype="multipart/form-data" id="add_product" onSubmit="return validate();">  
                  <div class="card-body">
                  <!-- action="iteration_data.php" method="POST" -->
                     <form   method="post">

                     <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
                        <div class="row"> 
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Name Of Job </label>
                                    <input type="text" class="form-control" id="exampleInputText1" name="name" value="<?php echo $_REQUEST["name"]; ?>" placeholder="Name Of Job">
                                    </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                            <label for="exampleInputPassword4">Assigned To</label>
                            <div class="input_field select_option">
                                    
                            <select name="members_name" id="membersSelect">
                                <?php
                                $category2 = mysqli_query($db, "SELECT * FROM members ");

                                while ($cat2 = mysqli_fetch_array($category2)) {
                                    $selected = ($_REQUEST["members_name"] == $cat2['id']) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $cat2['id'] ?>" <?php echo $selected ?>><?php echo $cat2['fname'] ?></option>
                                <?php } ?>
                            </select>

                                    <!-- <input type="text" name="memberIdHidden" id="memberIdHidden" value=""> -->
                                <div class="select_arrow"></div>
                                
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="row"> 
                        <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                            <label for="exampleInputPassword4">Client Name</label>
                            <div class="input_field select_option">
                                    
                            <select name="clientname" id="membersSelect">
                                <?php
                                $category2 = mysqli_query($db, "SELECT * FROM clients ");

                                while ($cat2 = mysqli_fetch_array($category2)) {
                                    
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
                                <textarea class="form-control" style="border: 1px solid #0003;" id="exampleFormControlTextarea1" name="notes" rows="1"><?php echo $_REQUEST["notes"];?></textarea>
                                    </div>
                                         </div>  
                            </div>
                            <div class="form-group">
						<label class="col-xs-12 " style="text-align:center;"><input name="Submit22" type="reset" class="btn btn-danger" value="Back"  onclick="location.replace('emergency_reminder.php')" />
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
                                                      <input name="Submit2" type="reset" class="btn btn-danger" value="Add New" onClick="location.replace('emergency_reminder.php?bid=sav')" />
                                                      <?php 
							
							} 
 

 
 ?>
                                                      <input name="Submit" type="reset" class="btn btn-danger" value="Reset" onClick="location.replace('emergency_reminder.php?bid=sav')" /></label></div>
						
						</div>
                            <!-- <button type="submit" class="btn btn-danger">Edit</button>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        
                     </form>
                  </div>

                  <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Emergency Reminder List</h5>
                              
                                </div>
                                <div class="table-responsive ">

                                   

                             
                                    <table class="table data-table mb-0 " >
                                    
                                        <thead class="table-color-heading">
                                            <tr class="">
                                               
                                                <th scope="col">Name of the Job   </th>
                                                <th scope="col">Clientname </th>
                                                <th scope="col">Notes </th>
                                                <th scope="col">Assigned To </th>
                                 
                                                <th scope="col" > 
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                //   WHERE members = '$name_member_id'
                              
                                $sql2 = "SELECT * FROM emergency_reminder ORDER BY id ASC";


                                //   echo $sql2;
                                //   exit;
                                    $result2=mysqli_query($db,$sql2);
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {
                                       $id =$db_field2["id"];
                                       $name = $db_field2["emergencyname"];
                                       $members_name = $db_field2["members_name"];
                                       $clientname = $db_field2["clientname"];
                                       
                                       $notes = $db_field2["notes"];
                                    
                                        ?>  
                           
                                            <tr class="white-space-no-wrap">
                                            
                                            <!-- <td><?php echo $db_field2["id"] ?> </td> -->

                                            
                                            <input name="img" type="hidden" id="img" value="<?php echo $_REQUEST["id"]; ?>" />
                                                
                                         <td><?php echo $db_field2["emergencyname"] ?> </td>
                                         <td><?php echo $db_field2["clientname"] ?> </td>
                                         
                                         <td><?php echo $db_field2["notes"] ?> </td>
                                         <td>
                                            <?php 
                                            
                                            $members_name_query = "SELECT * FROM members WHERE id='$members_name'";
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
                                                    ?>
                                               
                                                <?php } }
                                            
                                             ?> 
                                        
                                        </td>
                                        

                                         
                                                                                     
                                               <td>
                                                    <div class="d-flex align-items-center">
                                                         <!-- <a class="" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="customer-view.html">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a> -->
                                                        <?php
                                                        echo "<a href='emergency_reminder.php?bid=up&id=$id&name=$name&members_name=$members_name&clientname=$clientname&notes=$notes' target='_parent'>";
                                                        ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                        <?php echo "</a>" ?>



                                                        <form action="emergency_job_delete.php" method="post">
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