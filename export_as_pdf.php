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
 

<!-- --------------------------------------------------row -->
<div class="row">
    <div class="col-lg-12">
      <div class="row justify-content-center">
      
        <div class="col-lg-12">
          <div class="card card-block card-stretch">
            <div class="card-body p-0">
              <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="font-weight-bold"><u>Both Client vs Team Member Report </u></h5>
              </div>

              <div class="row mr_5 justify-content-center">
                <div class="col-lg-12">
                <form id="exportForm" method="POST">
            <div class="row" style="margin:10px;">
                    <div class="col-lg-2 col-md-2 mr_5">
                        <label class="filter_assigned_label">Export start Date </label>
                
                    </div>
                    <div class="col-lg-5 col-md-5 mr_5">

                        <input placeholder="From date" class="filter_date" type="date" id="start_date" name="start_date">
                    </div>
            </div>
            <div class="row" style="margin:10px;">
                <div class="col-lg-2 col-md-2 mr_5">
                    <label class="filter_assigned_label">Export End Date </label>
                    
                </div>
                <div class="col-lg-5 col-md-5 mr_5">

                <input placeholder="To date" class="filter_date" type="date" id="end_date" name="end_date">
                </div>
            </div>
            <div class="row" style="margin:10px;">
                <div class="col-lg-2 col-md-2 mr_5">
                    <label class="filter_assigned_label">Client Name </label>
                
                </div>
          
                    <div class="col-lg-5 col-md-5 mr_5">

                        <select id="clientName" name="clientname" class="filter_assigned">
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
                </div>
            
            <div class="row" style="margin:10px;">
                <div class="col-lg-2 col-md-2 mr_5">
                    <label class="filter_assigned_label">Member Name </label>
            
                </div>
                <div class="col-lg-5 col-md-5 mr_5">

                    <select id="memberName" name="member_name" class="filter_assigned">
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
            <div class="col-lg-4 col-md-4 mr_5" style="margin-bottom:15px;">
                <div style="float:right;" >
                    <button class="btn" type="submit">Export Selected</button>
                    <button type="button" class="btn" id="resetButton">Reset</button>
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
                  <form method="POST" action="report_members_pdf.php" onsubmit="return validateDateRange()">
                     <div class="row" style="margin:10px;">
                        <div class="col-lg-3 col-md-2 mr_5">
                            <label class="filter_assigned_label">Export Start Date </label>
                    
                        </div>
                        <div class="col-lg-5 col-md-5 mr_5">

                            <input placeholder="From date" class="filter_date" type="date" id="start_date" name="start_date">
                        </div>
                </div>
                <div class="row" style="margin:10px;">
                    <div class="col-lg-3 col-md-2 mr_5">
                        <label class="filter_assigned_label">Export End Date </label>
                        
                    </div>
                    <div class="col-lg-5 col-md-5 mr_5">

                    <input placeholder="To date" class="filter_date" type="date" id="end_date" name="end_date">
                    </div>
                </div>

                      <div class="col-lg-6 col-md-2 mr_5">
                       
                        <input type="hidden" placeholder="To date" class="filter_date" type="date" id="end_date" name="member_name" value="<?php echo $name_member_id;?>">
                      </div>
                     
                      
                       <div class="col-lg-6 col-md-6 mr_5" style="margin-bottom:15px;">
                            <div class="" style="float: right;margin-bottom: 18px;" >
                                <button class="btn" type="submit">Export Selected</button>
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

<script>
        document.getElementById('exportForm').addEventListener('submit', function(event) {
            var clientName = document.getElementById('clientName').value;
            var memberName = document.getElementById('memberName').value;
            var form = event.target;

            if (clientName !== '0' && memberName !== '0') {
                form.action = 'export_both.php';
            } else if (clientName !== '0') {
                form.action = 'export_range_pdf.php';
            } else if (memberName !== '0') {
                form.action = 'report_members_pdf.php';
            } else {
                alert('Please select at least one filter.');
                event.preventDefault(); // Prevent form submission
            }
        });
        
            document.getElementById('resetButton').addEventListener('click', function() {
            location.reload();
        });
    </script>
    


    <?php
include('footer.php');
    ?>
    <?php } ?>