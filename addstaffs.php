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

$career=1;  

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    

    // Get form data and sanitize inputs
    $fname = mysqli_real_escape_string($db, $_POST["fname"]);
    $lname = mysqli_real_escape_string($db, $_POST["lname"]);
    $username = mysqli_real_escape_string($db, $_POST["username"]);
    $designation = mysqli_real_escape_string($db, $_POST["designation"]);
    $doj = mysqli_real_escape_string($db, $_POST["doj"]);
    // $password_mail=$_REQUEST['password'];
    $password = substr(md5($_REQUEST['password']), 25);

    // SQL query to insert data into members table
    $insert_query = "INSERT INTO members (fname, lname, designation, username, doj, password, status) 
                     VALUES ('$fname', '$lname', '$designation', '$username', '$doj', '$password','1')";
                    //  echo $insert_query;
                    //  exit;

    // Execute the query
    if (mysqli_query($db, $insert_query)) {
        // Deletion successful
        echo '<script>alert("Staff Added successfully");</script>';
       
    } else {
        // Deletion failed
        echo '<script>alert("Failed to add staff");</script>';
    }

    // Close database connection
    mysqli_close($db);
}


include('top.php');

$create=1;



		 
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
                        <h4 class="card-title">Staffs List</h4>
                     </div>
                  <div class="header-action">
                           <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false">
                              <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                              </svg>
                           </i>
                        </div>
                  </div>

                  
                  <div class="card-body">
                  <!-- action="iteration_data.php" method="POST" -->
                  <form action=""  method="post" enctype="multipart/form-data" >  

                     <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
                        <div class="row"> 
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">First Name </label>
                                    
                                    <input type="text" class="form-control" id="fname" name="fname"  >
                                    </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Last Name </label>
                                    
                                    <input type="text" class="form-control" id="lname" name="lname"  >
                                    </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">	Designation </label>
                                    
                                    <input type="text" class="form-control" id="designation" name="designation"  >
                                    </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                <label for="exampleInputPassword4">Username For Portal</label>
                                <input type="text" class="form-control" id="username" name="username" value="@avatarstaff">
                                <!-- <span id="username-error" style="color: red;"></span> -->
                                
                                 </div>
                            </div>
                           
                        </div>
                        <div class="row"> 
                        <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                            <label for="exampleInputPassword4">D.O.J</label>
                            <input type="date" class="form-control" id="doj" name="doj" >
                           
                                 </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                            <label for="exampleInputPassword4">Password</label>
                            <input type="text" class="form-control" id="deadline" name="password"  value="avatarstaff" >
                           
                                 </div>
                            </div>
                                 
                                   
                        </div>
                        <div class="row justify-content-center"> 
                            <div class="form-group">
                            <button class="btn btn-primary" type="submit">ADD Staff</button>&nbsp;&nbsp;
                            <!-- <button type="submit" class="btn btn-danger">Edit</button>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        
                     </form>
                  </div>
                  </div>

                  <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Staff List</h5>
                              
                                </div>
                                <div class="table-responsive ">

                                

                             
                                    <table class="table data-table mb-0 " >
                                    
                                        <thead class="table-color-heading">
                                            <tr class="">
                                                <th scope="col">Profile Picture  </th>
                                                <th scope="col"> Username  </th>
                                                <th scope="col"> Name /  Designation </th>
                                                <th scope="col">Email  </th>
                                                <th scope="col">Mobile  </th>
                                                
                                               
                                 
                                                <th scope="col" > 
                                                    Action    </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                //   WHERE members = '$name_member_id'
                              
                                $sql2 = "SELECT * FROM members WHERE id != 1 ORDER BY id ASC";



                                //   echo $sql2;
                                //   exit;
                                    $result2=mysqli_query($db,$sql2);
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {
                                       $id =$db_field2["id"];
                                       $member_names = $db_field2["fname"] . ' ' . $db_field2["lname"];
                                       $username = $db_field2["username"];
                                       $email = $db_field2["email"];
                                       $mobile	 = $db_field2["mobile"];
                                       $designation	 = $db_field2["designation"];
                                   
                                    
                                        ?>  
                           
                                            <tr class="white-space-no-wrap">
                                          
                                            <!-- <td><?php echo $db_field2["id"] ?> </td> -->

                                            
                                            <input name="img" type="hidden" id="img" value="<?php echo $_REQUEST["id"]; ?>" />
                                            <td><img src="<?php echo $db_field2["profile_picture"] ?>" width="80" style="border-radius:15px;"> </td>       
                                            <td><?php echo $username ?> </td>
                                         <td><?php echo $member_names ?> / <?php echo $designation ?> </td>
                                         <td><?php echo $email ?> </td>
                                         <td><?php echo $mobile ?> </td>
                                    
                                                                                     
                                               <td>
                                                    <div class="d-flex align-items-center">
                                                 
                                                        <?php
                                                        echo "<a href='viewstaffs.php?id=$id' >";
                                                        ?>
                                                        <button class="btn btn-primary">View </button>&nbsp;&nbsp;
                                                        <?php echo "</a>" ?>



                                                            
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