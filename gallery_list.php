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
        $name_member2 = $row['fname'];
        $name_member_id = $row['id'];
        
        // Output the name
        // echo $name_member;
        // die;
    }
}



include('top.php');

$create=1;

 ?>
 <?php 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteid'])) {
        $deleteid = mysqli_real_escape_string($db, $_POST['deleteid']);

        if ($deleteid > 0) {
            // Delete record
           $sql = "DELETE FROM gallery_image WHERE id='$deleteid'"; 
            
            if (mysqli_query($db, $sql)) {
                // Redirect after successful operation
                header("Location: gallery_list.php?success=deleted");
            } else {
                // Handle error
                echo 'Error: ' . mysqli_error($db);
            }
        }
        exit();
    }
}
 ?>
 
 
 <?php
include('left.php');
include('nav.php');
 ?>  
 <style>

.container {
            display: flex;
            justify-content: center;
            align-items: center;
           
        }
        .alert-success {
            color: #155724;
            background-color:rgba(0,255,0,0.3);
            border-color: #c3e6cb;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            transition: opacity 1s ease-in-out;
        }
        .alert-info {
            color: #0c5460;
            background-color:rgba(0,0,255,0.3);
            border-color: #bee5eb;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            transition: opacity 1s ease-in-out;
        }
        .alert-warning {
            color: #856404;
            background-color:rgba(255,0,0,0.3);
            border-color: #ffeeba;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            transition: opacity 1s ease-in-out;
        }
        .alert-hidden {
            opacity: 0;
            display: none;
        }
</style>

       
      <div class="content-page">
<div class="container-fluid">
        <div class="row">
        <div class="container">
    <?php
    // Display success message based on query parameter
    if (isset($_GET['success'])) {
        $message = '';
        $alertClass = '';

        switch ($_GET['success']) {
            case 'added':
                $message = 'Record added successfully!';
                $alertClass = 'alert-success';
                break;
            case 'updated':
                $message = 'Record updated successfully!';
                $alertClass = 'alert-info';
                break;
            case 'deleted':
                $message = 'Record deleted successfully!';
                $alertClass = 'alert-warning';
                break;
        }

        if ($message) {
            echo '<div id="alert-message" class="' . htmlspecialchars($alertClass) . '">' . htmlspecialchars($message) . '</div>';
        }
    }
    ?>
</div>
            
            <div class="col-lg-12">
                     
                <div class="row">
                <div class="col-lg-12">
    <div class="card card-block card-stretch">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="font-weight-bold">Gallery Image List</h5>
                <a href="gallery_upload.php">
                    <button class="btn btn-success btn-sm">
                    <i class="fa fa-plus-square"></i>&nbsp; 
                        Add Image
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

                    <div class="col-lg-12">
                        <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <!-- <h5 class="font-weight-bold">Gallery List</h5> -->
                                    <a href="gallery_grid.php">
                                        <button class="btn btn-secondary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Gallery Grid
                                        </button>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <div class="" style="margin: 0px 18px;">
                                    <!-- <button type="button" class="btn btn-danger" id="deleteSelected" style="background:red;"> <i class="fa fa-trash-o"></i>&nbsp; Delete Selected</button> -->
                                    </div>
                                    <table class="table data-table mb-0">
    <thead class="table-color-heading">
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Type</th>
            <th scope="col">Client</th>
            <th scope="col">Image File</th>
            <th scope="col">Status</th>
            <th scope="col" class="text-right">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql2 = "SELECT * FROM gallery_image ORDER BY id DESC";
        $result2 = mysqli_query($db, $sql2);
        while ($db_field2 = mysqli_fetch_array($result2)) {
        ?>
            <tr class="white-space-no-wrap">
                <td><?php echo $db_field2["name"]; ?></td>
                <td><?php echo $db_field2["category"]; ?></td>
                <td><?php echo $db_field2["type"]; ?></td>
                <td><?php echo $db_field2["client"]; ?></td>
                <td>
                    <?php
                    if (!empty($db_field2["image_file"])) {
                        $fileLinks = explode("\n", $db_field2["image_file"]);
                        foreach ($fileLinks as $additionalFileLink) {
                            echo '<a href="' . $additionalFileLink . '" target="_blank">Image File</a><br>';
                        }
                    }
                    ?>
                </td>
                <td><?php echo $db_field2["status"]; ?></td>
                <td>
                    <a href="gallery_upload.php?id=<?php echo $db_field2['id']; ?>">
                        <button class="badge badge-primary" style="border:none;" data-toggle="tooltip" data-placement="top" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                    </a>
                    &nbsp; &nbsp;
                    <form action="gallery_list.php" method="POST" style="display: inline;">
    <input type="hidden" name="deleteid" value="<?php echo isset($db_field2['id']) ? htmlspecialchars($db_field2['id']) : ''; ?>">
    <button type="submit" class="badge badge-danger" style="border:none;" data-toggle="tooltip" data-placement="top" title="Delete">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
</form>
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




    <!-- Wrapper End-->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var alert = document.getElementById('alert-message');
    if (alert) {
        setTimeout(function() {
            alert.classList.add('alert-hidden');
        }, 3000); // Hide after 5 seconds
    }
});









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

    function openmemberpopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;
        var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

    var popup = window.open("edit_members.php?id=" + jobId + "&logname=" + logName, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

        if (popup) {
            popup.focus();
        } else {
            alert('Please allow pop-ups to enter the date.');
        }
    }

    function openreferencepopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;
        var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

    var popup = window.open("edit_reference.php?id=" + jobId, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

        if (popup) {
            popup.focus();
        } else {
            alert('Please allow pop-ups to enter the date.');
        }
    }

    function openmemberpopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;
        var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

    var popup = window.open("member_created.php?id=" + jobId + "&logname=" + logName, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

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