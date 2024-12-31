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

$add_client=1;

?>


<?php
include("connection.php");

if ($_POST["Submit"]=="Add"){
   $clientname = $_POST["name"];
   $email = $_POST["email"];
   $mobile_number = $_POST["phone"];
   $location = $_POST["locations"];
   $address = $_POST["address"];
   $status = $_POST["status"]; // Assuming you add name attribute to select field
   $cus_date = date("Y-m-d");

   
   // SQL query to insert data into clients table
   $sql = "INSERT INTO clients (name, email, phone, location, address, status, enddate)
   VALUES ('$clientname', '$email', '$mobile_number', '$location', '$address', '$status', '$cus_date')";

   // echo($sql);
   // exit;
   if (!mysqli_query($db,$sql)){die('Error: ' . mysqli_error());}
 
 }

 if ($_POST["Submit"] == "Update") {
   // Construct the update query
   $id = mysqli_real_escape_string($db, $_POST['id1']);
   $clientname = mysqli_real_escape_string($db, $_POST["name"]);
$email = mysqli_real_escape_string($db, $_POST["email"]);
$mobile_number = mysqli_real_escape_string($db, $_POST["phone"]);
$location = mysqli_real_escape_string($db, $_POST["locations"]);
$address = mysqli_real_escape_string($db, $_POST["address"]);
$status = mysqli_real_escape_string($db, $_POST["status"]); // Assuming you add name attribute to select field
$cus_date = date("Y-m-d");

// SQL query to update data in clients table
$update_sql = "UPDATE clients SET 
               name = '$clientname',
               email = '$email',
               phone = '$mobile_number',
               location = '$location',
               address = '$address',
               status = '$status',
               enddate = '$cus_date'
               WHERE id = $id";
   // echo $sql;
   // exit;
   // Execute the query
   if (!mysqli_query($db, $update_sql)) {
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
                        <h4 class="card-title">ADD/EDIT Client List</h4>
                     </div>
                  <div class="header-action">
                           <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false">
                              <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                              </svg>
                           </i>
                        </div>
                  </div>

        <form action="add_clients.php"  method="post" enctype="multipart/form-data" id="add_product" onSubmit="return validate();">   
                  <div class="card-body">
                  <!-- action="iteration_data.php" method="POST" -->
                     <form   method="post">

                     <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
                        <div class="row"> 
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Client Name </label>
                                    <input type="text" class="form-control" id="clientname" name="name" value="<?php echo $_REQUEST["name"]; ?>"  required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label for="exampleInputText1">Email </label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $_REQUEST["email"]; ?>" required="">
                                        </div>
                                </div>
                        </div>
                        <div class="row"> 
                               
                                <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label for="exampleInputText1">Mobile Number </label>
                                        <input type="text" class="form-control" id="exampleInputText1" name="phone" value="<?php echo $_REQUEST["phone"]; ?>" >
                                        </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Location </label>
                                    <input type="text" class="form-control" id="exampleInputText1" name="locations" value="<?php echo $_REQUEST["locations"]; ?>" >
                                    </div>
                                </div>
                        </div>
                        <div class="row"> 
                              
                                <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label for="exampleFormControlTextarea1"> Address</label>
                           <textarea class="form-control" id="address" name="address" rows="3"><?php echo $_REQUEST["address"]; ?></textarea>
                                        </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                            <label for="exampleInputPassword4">Status</label>
                                            
                                                
                                            <select class="form-control mb-3" name="status">
                                                                <!-- <option selected="1">Active</option> -->
                                                              <option value="Active">Active</option>
                                                                <option value="InActive">Inactive</option>
                                                                
                                                                </select>

                                                
                                            
                                            
                                            </div>
                                        </div>
                        </div>
                    
                    
                   
                        <div class="row"> 
                            <div class="form-group">
						<label class="col-xs-12 " style="text-align:center;"><input name="Submit22" type="reset" class="btn btn-danger" value="Back"  onclick="location.replace('add_clients.php')" />
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
                                                      <input name="Submit2" type="reset" class="btn btn-danger" value="Add New" onClick="location.replace('add_clients.php?bid=sav')" />
                                                      <?php 
							
							} 
 

 
 ?>
                                                      <input name="Submit" type="reset" class="btn btn-danger" value="Reset" onClick="location.replace('add_clients.php?bid=sav')" /></label></div>
						
						</div>
                            <!-- <button type="submit" class="btn btn-danger">Edit</button>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        
                     </form>
                  </div>
                  </div>


                  <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Clients  List</h5>
                              
                                </div>
                                <div class="table-responsive ">

                                

                             
                                <table class="table data-table mb-0 " >
                                    
                                    <thead class="table-color-heading">
                                        <tr class="">
                                        
                                            <th scope="col">Client Name  </th>
                                            <th scope="col">Email  </th>
                                            <th scope="col">Mobile  </th>
                                            <th scope="col">Location </th>
                                            <th scope="col">Status </th>
                             
                                            <th scope="col" > 
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                            //   WHERE members = '$name_member_id'
                          
                            $sql2 = "SELECT * FROM clients ORDER BY name";



                            //   echo $sql2;
                            //   exit;
                                $result2=mysqli_query($db,$sql2);
                                
                                $num=1;
                                while ($db_field2 = mysqli_fetch_array($result2)) {
                                   $id =$db_field2["id"];
                                  
                                
                                    ?>  
                       
                                        <tr class="white-space-no-wrap">
                                   
                                        <td style="display:none;"><?php echo $db_field2["id"] ?> </td>

                                        
                                        <!-- <input name="img" type="hidden" id="img" value="<?php echo $_REQUEST["id"]; ?>" /> -->
                                            
                                     <td><?php echo $db_field2["name"] ?> </td>
                                    <td> <a href="mailto:<?php echo $db_field2["email"] ?>"> <?php echo $db_field2["email"] ?> </a></td>
                                     <td><a href="mailto:<?php echo $db_field2["phone"] ?>"> <?php echo $db_field2["phone"] ?> </a> </td>
                                     <td><?php echo $db_field2["location"] ?> </td>
                                     <td>
                                        <?php
                                        // Check the status value and print the appropriate text
                                        if ($db_field2["status"] == '1') {
                                            echo "Active";
                                        } else {
                                            echo "Inactive";
                                        }
                                        ?>
                                    </td>

                  
                                    

                                     
                                                                                 
                                           <td>
                                                <div class="d-flex align-items-center">
                                                
                                                    <div style="display:none;">
                                                    <?php
                                                    echo "<a href='add_clients.php?bid=up&id=$id&name=" . $db_field2["name"] . "&email=" . $db_field2["email"] . "&phone=" . $db_field2["phone"] . "&locations=" . $db_field2["location"] . "&address=" . $db_field2["address"] . "&status=&" . $db_field2["status"] . "' target='_parent'>";
                                                    ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                    <?php echo "</a>" ?>
                                                </div>



                                                      <a href="add_clients_details.php?id=<?php echo $db_field2["id"]; ?>&name=<?php echo $db_field2["name"] ?>"> <button class="btn btn-success">ADD MORE</button></a>
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
    </div>
    


    <?php
include('footer.php');
    ?>
    <?php } ?>