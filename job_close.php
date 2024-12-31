

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
        
        // Output the name
        // echo $name_member;
        // die;
    }
}



?>

<?php
// print_r($_POST);
// exit;

include('left.php');
include('nav.php');
 ?>  
<style>
   .form-control {
    height: 46px;
    line-height: 45px;
    background: #fff;
    border: 1px solid #716d6d;
    font-size: 14px;
    color: #324253;
    border-radius: 5px;
    box-shadow: none;
}
</style>
<div class="content-page">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12 col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Close Job Form</h4>
                     </div>
                  <div class="header-action">
                           <i data-toggle="collapse" data-target="#form-element-1" aria-expanded="false">
                              <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                              </svg>
                           </i>
                        </div>
                  </div>
                  <div class="card-body">
                     <div class="collapse" id="form-element-1">
                 
                        </div>
                     <form action="jobclose_confirm.php" method="post" enctype="multipart/form-data" >
                        <?php
                        $job_id_closing=$_REQUEST['job_id_closing'];
                        $sqlUpdated = "SELECT * FROM jobcreate WHERE id = '$job_id_closing'";
                          $resultUpdated = mysqli_query($db, $sqlUpdated);
                        //   echo $sqlUpdated;
                        //   exit;

                          if ($resultUpdated) {
                            // Check if any rows were returned
                            if (mysqli_num_rows($result) > 0) {
                                // Fetch the result as an associative array
                                $row = mysqli_fetch_assoc($resultUpdated);
                                
                                // Access the 'name' column from the result
                                $clientname = $row['clientname'];
                                $job = $row['job'];
                                $members_id_no = $row['members'];
                                $assigned_by = $row['assigned_by'];
                                $job_type = $row['job_type'];
                                $completion = $row['completion'];
                                
                                // Output the name
                                // echo $name_member;
                                // die;
                            }
                        }
                       
                        ?>
                         <input type="hidden" class="form-control" id="jobclose_id" name="jobclose_id" value="<?php echo  $job_id_closing; ?>" >
                                 <div class="form-group">
                                <label for="email">Client Name</label>
                                <input type="text" class="form-control" id="client_name" value="<?php echo  $clientname; ?>" readonly>
                                <input type="hidden" class="form-control" name="client_name1" id="client_name1" value="<?php echo  $clientname; ?>" >
                                </div>
                                <div class="form-group">
                                <label for="pwd">Job Name:</label>
                                <input type="text" class="form-control" id="pwd" value="<?php echo  $job; ?>" readonly>
                                <input type="hidden" class="form-control" name="job_name" id="client_name1" value="<?php echo  $job; ?>" >
                                </div>
                                <div class="form-group">
                                <?php
                                                                $members_name_query = "SELECT * FROM members WHERE id='$members_id_no'";
                                                                $result_members = mysqli_query($db, $members_name_query);

                                                                if ($result_members) {
                                                                    $member_data = mysqli_fetch_assoc($result_members);

                                                                    if ($member_data) {
                                                                        // Assuming 'members' is a column in your 'members' table
                                                                        $member_name = $member_data['fname'];
                                                                        $lname = $member_data['lname'];
                                                                      
                                                                    } 
                                                                }
                                                                ?>
                            <label for="pwd">Assigned By</label>
                            <input type="text" class="form-control" id="pwd" value="<?php echo  $member_name.''.$lname ; ?>" readonly>
                            </div>
                                                  
                            <!-- -------------------- -->
                            <div class="form-group">
                             <label for="pwd">File Upload</label>
                                 <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="job_close_file[]" multiple id="files" required="">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <br><br>
                                <p class="text-center" style="color:red;">(Upload atleast one Compulsory image, only 5MB File for Storing Purpose) <p>
                             </div>
                             <p class="text-center"> (OR) </p>           
                               <div class="form-group">
                                 <label for="email">File Link</label>
                                 <input type="text" class="form-control" id="filelink" name="filelink" value="">
                                </div>
                                <p class="text-center"> (OR) </p>    
                                <div class="form-group">
                                 <label for="email">Notes: <span style="color:red;"> This will be Reflected in Clients and Members Reports, so type responsibly </span> </label>
                                 <!-- <input type="text" class="form-control" id="filelink" name="filelink" value=""> -->
                                  <textarea id="editor1" name="notes_output" rows="4" cols="50"></textarea>
                                </div>
                        
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="submit" class="btn bg-danger">Cancel</button>
                     </form>
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