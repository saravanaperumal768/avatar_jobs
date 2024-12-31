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
                                    <h5 class="font-weight-bold">Career Page Job List</h5>
                              
                                </div>
                                <div class="table-responsive ">

                               

                             
                                    <table class="table data-table mb-0 " >
                                    
                                        <thead class="table-color-heading">
                                            <tr class="">
                                           
                                                <th scope="col"> Name  </th>
                                                <th scope="col">Email  </th>
                                                <th scope="col">Mobile  </th>
                                                <th scope="col">Applying For  </th>
                                                <th scope="col">Resume  </th>
                                                
                                 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                //   WHERE members = '$name_member_id'
                              
                                $sql2 = "SELECT * FROM career_web ORDER BY id ASC";


                                //   echo $sql2;
                                //   exit;
                                    $result2=mysqli_query($db,$sql2);
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {
                                       $id =$db_field2["id"];
                                       $name = $db_field2["name"];
                                       $email = $db_field2["email"];
                                       $mobile	 = $db_field2["mobile"];
                                       $applying_for	 = $db_field2["applying_for"];
                                   
                                    
                                        ?>  
                           
                                            <tr class="white-space-no-wrap">
                                       
                                            <!-- <td><?php echo $db_field2["id"] ?> </td> -->

                                            
                                            <input name="img" type="hidden" id="img" value="<?php echo $_REQUEST["id"]; ?>" />
                                                
                                         <td><?php echo $db_field2["name"] ?> </td>
                                         <td><a href="mailto:<?php echo $db_field2["email"] ?>"><?php echo $db_field2["email"] ?> </a></td>
                                         <td><a href="tel:<?php echo $db_field2["mobile"] ?>"><?php echo $db_field2["mobile"] ?></a> </td>
                                         <td><?php echo $db_field2["applying_for"] ?> </td>
                                         <td><?php if(!empty($db_field2["resume_file"])){ ?><a style="color:blue;" href="../avatarwebsite/resume_files/<?php echo $db_field2["resume_file"] ?>" target="_blank">Resume Link </a><?php } else { ?> <p style="color:red;"> No Data Found </p> <?php }?></td>
                                         <!-- <td><a href="../avatarwebsite/portfolio_files/<?php echo $db_field2["portfolio_link"] ?>" target="_blank">Portfolio Link </a></td> -->
                                         <td> <a href="career_details.php?id=<?php echo $db_field2["id"] ?>" target="_blank"><button class="btn btn-primary">View More </button> </a></td> 
                                    
                                                                                     
                                            
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