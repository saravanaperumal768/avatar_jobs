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

$career_list=1;  

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
table.dataTable tbody td, table.dataTable tbody th {
   padding: 15px 20px;
}
a{
   color:blue;
}
@media(max-width:991px){
   input#timeInput {
   width: 70%;
   margin: 7px;
   padding: 7px;
}
}

.input-switch{
	display: none;
}

.label-switch{
	display: inline-block;
	position: relative;
}

.label-switch::before, .label-switch::after{
	content: "";
	display: inline-block;
	cursor: pointer;
	transition: all 0.5s;
}

.label-switch::before {
    width: 3em;
    height: 1em;
    border: 1px solid #757575;
    border-radius: 4em;
    background: #888888;
}

.label-switch::after {
    position: absolute;
    left: 0;
    top: -20%;
    width: 1.5em;
    height: 1.5em;
    border: 1px solid #757575;
    border-radius: 4em;
    background: #ffffff;
}

.input-switch:checked ~ .label-switch::before {
    background: #00a900;
    border-color: #008e00;
}

.input-switch:checked ~ .label-switch::after {
    left: unset;
    right: 0;
    background: #00ce00;
    border-color: #009a00;
}

.info-text {
	display: inline-block;
}


</style>
      
     <div class="content-page">
<div class="container-fluid">
       <div class="row">
           
           

                 <div class="card card-block card-stretch">
                           <div class="card-body p-0">
                           <div class="d-flex justify-content-between align-items-center p-3">
                                   <h5 class="font-weight-bold">Staff Details</h5>
                             
                               </div>
                               <div class="table-responsive ">

                               

                            
                                   <table class="table data-table mb-0 " >
                                   
                                  
                                       <tbody >

                                       <?php
                       
                               $id=$_GET['id'];
                               $sql2 = "SELECT * FROM members where id=$id ";


                               //   echo $sql2;
                               //   exit;
                                   $result2=mysqli_query($db,$sql2);
                                   $num=1;
                                   while ($db_field2 = mysqli_fetch_array($result2)) {
                                      $id =$db_field2["id"];
                                      $status =$db_field2["status"];
                                      $name =$db_field2["fname"]. $db_field2["lname"];
                                     
                                  
                                   
                                       ?>  
                                        
                                           <tr class="white-space-no-wrap">
                                           <td>DP </td>
                                           <td>
                                           <?php
                                           if(!empty($db_field2["profile_picture"])){ ?>
                                          <img src="<?php echo $db_field2["profile_picture"] ?>" width="70"> 
                                          <?php }else{ ?>
                                            <p style="color:red;">No Data Found </p>
                                            <?php } ?>
                                            </td>
                                           </tr>
                                           
                          
                                           <tr class="white-space-no-wrap">
                                           <td >Name  </td>
                                          <td><?php echo $name ?> </td>
                                     
                                           </tr>
                                           <tr class="white-space-no-wrap">
                                           <td>Designation  </td>
                                          <td><?php echo $db_field2["designation"] ?> </td>
                                     
                                           </tr>
                                           <tr class="white-space-no-wrap">
                                           <td>Email  </td>
                                           <td><a href="mailto:<?php echo $db_field2["email"] ?>"><?php echo $db_field2["email"] ?> </a></td>
                                        
                                     
                                           </tr>
                                           <tr class="white-space-no-wrap">
                                           <td>Mobile  </td>
                                           <td><a href="tel:<?php echo $db_field2["mobile"] ?>"><?php echo $db_field2["mobile"] ?></a> </td>
                                     
                                           </tr>
                                           <tr class="white-space-no-wrap">
                                           <td>Username  </td>
                                          <td><?php echo $db_field2["username"] ?> </td>
                                     
                                           </tr>
                                          
                                           <tr class="white-space-no-wrap">
                                           <td>City  </td>
                                          <td><?php echo $db_field2["city"] ?> </td>
                                     
                                           </tr>

                                           <tr class="white-space-no-wrap">
                                           <td>Gender  </td>
                                          <td><?php echo $db_field2["gender"] ?> </td>
                                     
                                           </tr>

                                           <tr class="white-space-no-wrap">
                                           <td>D.O.B  </td>
                                          <td><?php echo $db_field2["dob"] ?> </td>
                                     
                                           </tr>

                                           <tr class="white-space-no-wrap">
                                           <td>DOJ  </td>
                                          <td><?php echo $db_field2["doj"] ?> </td>
                                     
                                           </tr>

                                           <tr class="white-space-no-wrap">
                                           <td>Job Location  </td>
                                          <td><?php echo $db_field2["job_location"] ?> </td>
                                     
                                           </tr>

                                           <tr class="white-space-no-wrap">
                                           <td>	Bank Account Details	  </td>
                                          <td><?php echo $db_field2["bank_account_details"] ?> </td>
                                     
                                           </tr>
                                           <tr class="white-space-no-wrap">
                                           <td>Address	  </td>
                                          <td><?php echo $db_field2["address"] ?> </td>
                                     
                                           </tr>
                                         

                                       <tr>
                                       <td>Status	  </td>
                                       <td height="32" align="left" class="generalfont" style="background:#fff;" >
                                    <input type="hidden" name="styleid_status_<?php echo $id; ?>" id="styleid_status_<?php echo $id; ?>" value="<?php echo $id; ?>">
                                    <input type="hidden" name="status_<?php echo $id; ?>" id="statusInput_<?php echo $id; ?>" value="<?php echo $status; ?>">
                                    <div align="left" style="margin-left:10px;padding:10px; background:#fff;">
                                        <span class="style54" style="color: black;padding:5px;line-height: 25px;">
                                            <input class='input-switch' type="checkbox" id="demo_<?php echo $id; ?>" <?php echo $status == 1 ? 'checked' : ''; ?> onchange="updateStatus(this)"/> <!-- Set checkbox state based on PHP variable -->
                                            <label class="label-switch" for="demo_<?php echo $id; ?>"></label>
                                            <span class="info-text"><?php echo $status == 1 ? 'Active' : 'Inactive'; ?></span>
                                        </span>
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
   
   <script>
function updateStatus(checkbox) {
    var status = checkbox.checked ? 1 : 0;
    var styleId = checkbox.id.split('_').pop(); // Extract style ID from checkbox ID
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'status_active.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Update status text if needed
            var infoText = document.querySelector('#statusInput_' + styleId);
            infoText.value = status;
            var infoTextDisplay = document.querySelector('.info-text');
            infoTextDisplay.innerHTML = status === '1' ? "Active" : "Inactive";
        }
    };
    xhr.send('style_id=' + styleId + '&status=' + status);
}

</script>

   <?php
include('footer.php');
   ?>
   <?php } ?>