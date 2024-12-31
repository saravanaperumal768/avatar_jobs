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
</style>
       
      <div class="content-page">
<div class="container-fluid">
        <div class="row">
            
            

                  <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Application Details</h5>
                              
                                </div>
                                <div class="table-responsive ">

                                

                             
                                    <table class="table data-table mb-0 " >
                                    
                                   
                                        <tbody >

                                        <?php
                        
                                $id=$_GET['id'];
                                $sql2 = "SELECT * FROM career_web where id=$id ";


                                //   echo $sql2;
                                //   exit;
                                    $result2=mysqli_query($db,$sql2);
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {
                                       $id =$db_field2["id"];
                                      
                                   
                                    
                                        ?>  
                           
                                            <tr class="white-space-no-wrap">
                                            <td >Name  </td>
                                           <td><?php echo $db_field2["name"] ?> </td>
                                      
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
                                            <td>Applying For  </td>
                                           <td><?php echo $db_field2["applying_for"] ?> </td>
                                      
                                            </tr>
                                            <tr class="white-space-no-wrap">
                                            <td>Current CTC  </td>
                                           <td><?php echo $db_field2["current_ctc"] ?> </td>
                                      
                                            </tr>

                                            <tr class="white-space-no-wrap">
                                            <td>DOJ  </td>
                                           <td><?php echo $db_field2["doj"] ?> </td>
                                      
                                            </tr>

                                            <tr class="white-space-no-wrap">
                                            <td>Location  </td>
                                           <td><?php echo $db_field2["location"] ?> </td>
                                      
                                            </tr>

                                            <tr class="white-space-no-wrap">
                                            <td>	Work Preference  </td>
                                           <td><?php echo $db_field2["work_preference"] ?> </td>
                                      
                                            </tr>
                                            <?php
                                            if(!empty($db_field2["portfolio_file"])){ ?>
                                            <tr class="white-space-no-wrap">
                                            <td>Portfolio File </td>
                                           <td><a style="color:blue;" href="../portfolio_files/<?php echo $db_field2["portfolio_file"] ?>" target="_blank"> Portfolio File Link</a> </td>
                                      
                                            </tr>
                                            <?php } ?>

                                            <?php
                                            if(!empty($db_field2["portfolio_file"])){ ?>
                                            <tr class="white-space-no-wrap">
                                            <td>Portfolio Link </td>
                                           <td><a style="color:blue;" href="<?php echo $db_field2["portfolio_link"] ?>" target="_blank"> Click Here To View</a> </td>
                                      
                                            </tr>
                                            <?php } ?>

                                            <?php
                                            if(!empty($db_field2["resume_file"])){ ?>
                                            <tr class="white-space-no-wrap">
                                            <td>Resume Link </td>
                                           <td><a style="color:blue;"  href="../resume_files/<?php echo $db_field2["resume_file"] ?>" target="_blank"> Click Here To View </a> </td>
                                      
                                            </tr>
                                            <?php } ?>
                                            <?php
                                            if(!empty($db_field2["comments"])){ ?>
                                            <tr class="white-space-no-wrap">
                                            <td>Cover Letter </td>
                                           <td><?php echo $db_field2["comments"] ?> </td>
                                      
                                            </tr>
                                            <?php } ?>

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