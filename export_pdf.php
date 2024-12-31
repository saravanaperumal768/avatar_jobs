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

$export_pdf=1;

 ?>
 
 
 <?php
include('left.php');
include('nav.php');
 ?>  
    
    <style>
        .filter_assigned {
    margin-right: 20px;
    margin: 0px 15px 9px 0px;
    border: 1px solid #550d9e;
    border-radius: 5px;
    padding: 4px 13px;
}
    </style>
      <div class="content-page">
<div class="container-fluid">
<?php
            if($name_member_id=='1'){
        ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
      
        <div class="col-lg-6">
          <div class="card card-block card-stretch">
            <div class="card-body p-0">
              <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="font-weight-bold"><u>Client Name Report</u></h5>
              </div>

              <div class="row mr_5 ">
                <div class="col-lg-12">
                  <form method="POST" action="export_range_pdf.php">
                    <div class="row " style="margin:10px;">
                      <div class="col-lg-6 col-md-6 mr_5">
                        <label class="filter_assigned_label"> Export start Date : </label>
                        <input placeholder="From date" class="filter_date" type="date" id="start_date" name="start_date">
                      </div>
                      <div class="col-lg-6 col-md-2 mr_5">
                        <label class="filter_assigned_label"> Export End Date : </label>
                        <input placeholder="To date" class="filter_date" type="date" id="end_date" name="end_date">
                      </div>
                      <div class="col-lg-6 col-md-6 mr_5" >
                        <label class="filter_assigned_label"> Client Name : </label>
                        <select id="assignedToFilter" name="clientname" class="filter_assigned">
                          <option value="0">Select Client Name</option>
                          <?php
                          $category2 = mysqli_query($db, "SELECT * FROM clients");
                          while ($cat2 = mysqli_fetch_array($category2)) {
                          ?>
                            <option value="<?php echo $cat2['name'] ?>"><?php echo $cat2['name'] ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                   
                      <div class="col-lg-12 col-md-12 mr_5">
                        <div class="margin-center">
                          <button class="btn btn-danger" type="submit">Export Selected</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
       

        <div class="col-lg-6">
          <div class="card card-block card-stretch">
            <div class="card-body p-0">
              <div class="d-flex justify-content-between align-items-center p-3">
                 <h5 class="font-weight-bold"><u>Team Member Report</u></h5>
              </div>

              <div class="row mr_5 ">
                <div class="col-lg-12">
                  <form method="POST" action="report_members_pdf.php">
                    <div class="row" style="margin:10px;">
                      <div class="col-lg-6 col-md-6 mr_5">
                        <label class="filter_assigned_label"> Export start Date : </label>
                        <input placeholder="From date" class="filter_date" type="date" id="start_date" name="start_date">
                      </div>
                      <div class="col-lg-6 col-md-2 mr_5">
                        <label class="filter_assigned_label"> Export End Date : </label>
                        <input placeholder="To date" class="filter_date" type="date" id="end_date" name="end_date">
                      </div>
                     
                      <div class="col-lg-6 col-md-6 mr_5" >
                        <label class="filter_assigned_label"> Member Name : </label>
                        <select id="assignedToFilter" name="member_name" class="filter_assigned">
                          <option value="0">Select Member Name</option>
                          <?php
                          $category2 = mysqli_query($db, "SELECT * FROM members");
                          while ($cat2 = mysqli_fetch_array($category2)) {
                          ?>
                            <option value="<?php echo $cat2['id'] ?>"><?php echo $cat2['fname'] . " " . $cat2['lname'] ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-lg-12 col-md-12 mr_5">
                        <div class="margin-center">
                          <button class="btn btn-danger" type="submit">Export Selected</button>
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

<!-- --------------------------------------------------row -->
<div class="row">
    <div class="col-lg-12">
      <div class="row justify-content-center">
      
        <div class="col-lg-6">
          <div class="card card-block card-stretch">
            <div class="card-body p-0">
              <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="font-weight-bold"><u>Both Client vs Team Member Report </u></h5>
              </div>

              <div class="row mr_5 justify-content-center">
                <div class="col-lg-12">
                  <form method="POST" action="export_both.php">
                    <div class="row justify-content-center" style="margin:10px;">
                      <div class="col-lg-6 col-md-6 mr_5">
                        <label class="filter_assigned_label"> Export start Date : </label>
                        <input placeholder="From date" class="filter_date" type="date" id="start_date" name="start_date">
                      </div>
                      <div class="col-lg-6 col-md-2 mr_5">
                        <label class="filter_assigned_label"> Export End Date : </label>
                        <input placeholder="To date" class="filter_date" type="date" id="end_date" name="end_date">
                      </div>
                      <div class="row">
                        <div class="col-lg-4 col-md-6 mr_5" style="margin:20px;">
                          <label class="filter_assigned_label"> Client Name : </label>
                          <select id="assignedToFilter" name="clientname" class="filter_assigned">
                            <option value="0">Select Client Name</option>
                            <?php
                            $category2 = mysqli_query($db, "SELECT * FROM clients");
                            while ($cat2 = mysqli_fetch_array($category2)) {
                            ?>
                              <option value="<?php echo $cat2['name'] ?>"><?php echo $cat2['name'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-lg-4 col-md-6 mr_5" style="margin:20px;">
                        <label class="filter_assigned_label"> Member Name : </label>
                        <select id="assignedToFilter" name="member_name" class="filter_assigned">
                          <option value="0">Select Member Name</option>
                          <?php
                          $category2 = mysqli_query($db, "SELECT * FROM members");
                          while ($cat2 = mysqli_fetch_array($category2)) {
                          ?>
                            <option value="<?php echo $cat2['id'] ?>"><?php echo $cat2['fname'] . " " . $cat2['lname'] ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        </div>
                      </div> 

                      

                      
                   
                      <div class="col-lg-12 col-md-12 mr_5">
                      <div class="margin-center">
                          <button class="btn btn-danger" type="submit">Export Selected</button>
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

  <?php } else {?>
    <div class="row">
    <div class="col-lg-12">
      <div class="row">
      
     
       

        <div class="col-lg-8">
          <div class="card card-block card-stretch">
            <div class="card-body p-0">
              <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="font-weight-bold"><u>Export Your Report PDF</u></h5>
              </div>

              <div class="row mr_5 justify-content-center">
                <div class="col-lg-12">
                  <form method="POST" action="report_members_pdf.php">
                    <div class="row justify-content-center" style="margin:10px;">
                      <div class="col-lg-6 col-md-6 mr_5">
                        <label class="filter_assigned_label"> Export start Date : </label>
                        <input placeholder="From date" class="filter_date" type="date" id="start_date" name="start_date">
                      </div>
                      <div class="col-lg-6 col-md-2 mr_5">
                        <label class="filter_assigned_label"> Export End Date : </label>
                        <input placeholder="To date" class="filter_date" type="date" id="end_date" name="end_date">
                      </div>

                      <div class="col-lg-6 col-md-2 mr_5">
                       
                        <input type="hidden" placeholder="To date" class="filter_date" type="date" id="end_date" name="member_name" value="<?php echo $name_member_id;?>">
                      </div>
                     
                      
                      <div class="col-lg-12 col-md-12 mr_5" style="margin:10px auto;">
                        <div class="center">
                          <button class="btn btn-danger" type="submit">Export Selected</button>
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
  <?php } ?>
</div>
</div>

    <!-- Wrapper End-->
    <script>
    function openDatePopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;

        var popup = window.open("edit_completion.php?id=" + jobId, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

        if (popup) {
            popup.focus();
        } else {
            alert('Please allow pop-ups to enter the date.');
        }
    }
</script>

    <?php
include('footer.php');
    ?>
    <?php } ?>