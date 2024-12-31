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



?>


<?php
include("connection.php");

if ($_POST["Submit"]=="Add"){
   $name = $_POST["name"];
   $submit_name = $_POST["submit_name"];
  

   
   // SQL query to insert data into clients table
   $sql = "INSERT INTO  type_of_work (name)
   VALUES ('$name')";

//    echo($sql);
//    exit;
   if (!mysqli_query($db,$sql)){die('Error: ' . mysqli_error());}
 
 }

 if ($_POST["Submit"] == "Update") {
   // Construct the update query
   $id = mysqli_real_escape_string($db, $_POST['id1']);
   $name = mysqli_real_escape_string($db, $_POST["name"]);

    $cus_date = date("Y-m-d");

// SQL query to update data in clients table
$update_sql = "UPDATE  type_of_work SET 
               name = '$name'
               
               WHERE id = '$id'";
//    echo $update_sql;
//    exit;
$result=mysqli_query($db,$update_sql);


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
                        <h4 class="card-title">ADD/EDIT TYPE OF WORK List</h4>
                     </div>
                  <div class="header-action">
                           <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false">
                              <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                              </svg>
                           </i>
                        </div>
                  </div>

        <form action="add_type_work.php"  method="post" enctype="multipart/form-data" id="add_product" onSubmit="return validate();">   
                  <div class="card-body">
                  <!-- action="iteration_data.php" method="POST" -->
                     <form   method="post">

                     <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
                     <input type="hidden" name="submit_name" value="<?php echo $name_member;?>" >
                        <div class="row"> 
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Type Of Work </label>
                                    <input type="text" class="form-control" id="job_type" name="name" value="<?php echo $_REQUEST["name"]; ?>" >
                                    </div>
                                </div>
                               
                        </div>
                     
                    
                   
                        <div class="row"> 
                            <div class="form-group">
						<label class="col-xs-12 " style="text-align:center;"><input name="Submit22" type="reset" class="btn btn-danger" value="Back"  onclick="location.replace('job_creation.php')" />
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
                                                      <input name="Submit2" type="reset" class="btn btn-danger" value="Add New" onClick="location.replace('add_type_work.php?bid=sav')" />
                                                      <?php 
							
							} 
 

 
 ?>
                                                      <input name="Submit" type="reset" class="btn btn-danger" value="Reset" onClick="location.replace('add_type_work.php?bid=sav')" /></label></div>
						
						</div>
                            <!-- <button type="submit" class="btn btn-danger">Edit</button>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        
                     </form>
                  </div>
                  </div>


                  <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold"> Type Of Work List</h5>
                              
                                </div>
                                <div class="table-responsive ">

                                

                             
                                <table class="table data-table mb-0 " >
                                    
                                    <thead class="table-color-heading">
                                        <tr class="">
                                        
                                            <th scope="col">Type Of Work </th>
                                           
                             
                                            <th scope="col" > 
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                            //   WHERE members = '$name_member_id'
                          
                            $sql2 = "SELECT * FROM  type_of_work ORDER BY id  ASC";


                            //   echo $sql2;
                            //   exit;
                                $result2=mysqli_query($db,$sql2);
                                
                                $num=1;
                                while ($db_field2 = mysqli_fetch_array($result2)) {
                                   $id =$db_field2["id"];
                                  
                                
                                    ?>  
                       
                                        <tr class="white-space-no-wrap">
                                   
                                        <td style="display:none;"><?php echo $db_field2["id"] ?> </td>

                                        
                                        
                                            
                                     <td><?php echo $db_field2["name"] ?> </td>
                                    
                  
                                    

                                     
                                                                                 
                                           <td>
                                                <div class="d-flex align-items-center">
                                                
                                                    <?php
                                                    echo "<a href='add_type_work.php?bid=up&id=" . $db_field2["id"] . "&name=" . $db_field2["name"] . "' target='_parent'>";
                                                    ?>
                                                    
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                    <?php echo "</a>" ?>
                                                    



                                                    <form action="delete_add_type_work.php" method="post">
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
    </div>
    


    <?php
include('footer.php');
    ?>
    <?php } ?>