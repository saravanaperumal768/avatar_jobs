


 
 
 <?php
 error_reporting(0);
 include('top.php');
 

 $staff=1;

include('left.php');
include('nav.php');
 ?> 

<style>
    textarea {
    width: 80%;
    padding: 8px 8px 9px 10px;
    height: 35px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    outline: none;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    font-size: 17px;
    height: 85px;
}
.btn a{
color :#fff;
  }
  .btn a:hover{
color :#000;
  }
</style>

<div class="content-page">
                <div class="container-fluid">
                <div class="row justify-content-center" >
                <button class="btn btn-primary"><a href="addstaffs.php" >Add Staffs </a> </button> &nbsp;
                    
                  </div>
                  <br>
                    <div class="row justify-content-center">
                            
                    <div class="table-responsive">
                                <h3 class="text-center"> Staff Details</h3>
                                    <table class="table data-table mb-0">
                                        <thead class="table-color-heading">
                                            <tr class="">
                                            
                                    <th scope="col">DP</th>
                                    <th scope="col">First / <br> Last Name</th>
                                    <th scope="col">D.O.J / <br> Location </th>
                                    <th scope="col">Email / Mobile <br> </th>
                                    <th scope="col">Bank Details </th>
                                
                                    <th scope="col">Address</th>
                                    <th scope="col">Action</th>
                                    
                                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                //   WHERE members = '$name_member_id'
                              
                                  $sql2 = "SELECT * FROM members WHERE id != 1 ORDER BY id Desc";
                                
                                    $result2=mysqli_query($db,$sql2);
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {
                                       $members_id_no =$db_field2["id"];
                                       $bank_account_details = $db_field2['bank_account_details'];
                                            
                                                   // Check for completion date nearing today's date
                                   
                                        ?>  
                                            <tr class="white-space-no-wrap">
                                          
                                            <td>
                                                <?php if (empty($db_field2["profile_picture"])) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                    
                                                    <div class="active-project-1 d-flex align-items-center mt-0 ">
                                                        <div class="h-avatar is-medium">
                                                         <img class="avatar rounded-circle" alt="<?php echo $db_field2["fname"]?>" src="<?php echo $db_field2["profile_picture"]?>">
                                                            </div>
                                                     
                                                    </div>
                                                <?php }?>
                                            </td>
                                                <td>
                                                <?php if (empty($db_field2["fname"])) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                    <?php echo $db_field2["fname"]?>
                                                    <?php echo $db_field2["lname"]?>
                                                <?php }?>
                                          
                                                </td>
                                                <!-- ------ -->
                                                <td>
                                                <?php if (empty($db_field2["doj"])) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                    <?php echo $db_field2["doj"]?>
                                                  <?php }?> / <br>
                                                  <?php if (empty($db_field2["job_location"])) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                    <?php echo $db_field2["job_location"]?>
                                                  <?php }?> 
                                                </td>

                                                  <!-- ------ -->
                                                  <td>
                                                <?php if (empty($db_field2["email"])) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                <?php echo $db_field2["email"]?> / <br>
                                                    <?php echo $db_field2["mobile"]?>
                                                <?php }?>
                                                </td>
                                                       <!-- ------ -->
                                                       <td>
                                                <?php if (empty($bank_account_details)) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                <textarea> 
                                                <?php echo $bank_account_details?> 
                                                </textarea> 
                                                <?php }?>
                                                </td>
                                                <!-- ----------- -->
                                                <td>
                                                <?php if (empty($db_field2["address"])) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                <textarea> 
                                                <?php echo $db_field2["address"];?> 
                                                </textarea> 
                                                <?php }?>
                                                </td>
                                       
                                           
                                       
                                       
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                  
                                                        <form action="delete_job.php" method="post">
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

<?php

include('footer.php');
 ?> 