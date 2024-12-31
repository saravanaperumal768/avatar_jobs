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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure form fields are set
    if (isset($_POST['category']) && isset($_POST['status'])) {
        // Escape input data
        $category = mysqli_real_escape_string($db, $_POST['category']);
        $status = mysqli_real_escape_string($db, $_POST['status']);
        $cus_date = date("Y-m-d");
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id > 0) {
            // Update existing record
            $sql = "UPDATE image_category SET category='$category', status='$status', updated_at='$cus_date' WHERE id='$id'"; 
            $message = "updated";
        } else {
            // Insert new record
            $sql = "INSERT INTO image_category (category, status, create_at) VALUES ('$category', '$status', '$cus_date')";
            $message = "added";
        }

        if (mysqli_query($db, $sql)) {
            // Redirect after successful operation
            header("Location: add_category_image.php?success=$message");
        } else {
            // Handle error
            echo 'Error: ' . mysqli_error($db);
        }
        exit();
    }

    if (isset($_POST['deleteid'])) {
        $deleteid = mysqli_real_escape_string($db, $_POST['deleteid']);

        if ($deleteid > 0) {
            // Delete record
            $sql = "DELETE FROM image_category WHERE id='$deleteid'";
            
            if (mysqli_query($db, $sql)) {
                // Redirect after successful operation
                header("Location: add_category_image.php?success=deleted");
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
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <?php
// Check if an ID is set (you can replace 'id' with the appropriate key if needed)
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    echo '<h4 class="card-title mb-0">EDIT Images Category</h4>';
} else {
    echo '<h4 class="card-title mb-0">ADD Images Category</h4>';
}
?>
                     
                        <!-- <button class="btn btn-outline-secondary" data-toggle="collapse" data-target="#form-element-6">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </button> -->
                    </div>
                    <?php
                        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                        $image_category_query = mysqli_query($db, "SELECT * FROM image_category WHERE id='$id'");
                        $image_category = mysqli_fetch_assoc($image_category_query);
                    ?>

<div class="card-body">
    <form action="add_category_image.php" method="post" enctype="multipart/form-data" id="add_product" onSubmit="return validate();">
        <input name="id" type="hidden" value="<?php echo htmlspecialchars($image_category['id']); ?>" />
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($image_category['category']); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control mb-3" name="status">
                        <option value="Active" <?php if ($image_category['status'] == 'Active') echo 'selected'; ?>>Active</option>
                        <option value="Inactive" <?php if ($image_category['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            


            <?php
// Check if an ID is set (you can replace 'id' with the appropriate key if needed)
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    echo '<button type="submit" class="btn btn-secondary" aria-label="Reset form and save">Update</button>';
} else {
    echo '<button type="submit" class="btn btn-secondary" aria-label="Reset form and save">Submit</button>';
}
?>
            &nbsp; &nbsp; &nbsp;
            <button type="button" class="btn btn-danger" onclick="location.replace('gallery_upload.php')" aria-label="Go back">Back</button>
        </div>
    </form>
</div>

</div></div>
<div class="col-lg-12">
<div class="card card-block card-stretch">
                <div class="card card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h5 class="font-weight-bold mb-0">Images Type List</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table data-table mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th scope="col">Image Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql2 = "SELECT * FROM image_category ORDER BY id";
                                    $result2 = mysqli_query($db, $sql2);
                                    while ($db_field2 = mysqli_fetch_array($result2)): ?>
                                        <tr>
                                            <td><?php echo $db_field2["category"]; ?></td>
                                            <td><?php echo $db_field2["status"]; ?></td>
                                            <td>
                                            <a href="add_category_image.php?id=<?php echo $db_field2['id']; ?>">
                        <button class="badge badge-primary" style="border:none;" data-toggle="tooltip" data-placement="top" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                    </a>
                    &nbsp; &nbsp;
                    <form action="add_category_image.php" method="POST" style="display: inline;">
    <input type="hidden" name="deleteid" value="<?php echo isset($db_field2['id']) ? htmlspecialchars($db_field2['id']) : ''; ?>">
    <button type="submit" class="badge badge-danger" style="border:none;" data-toggle="tooltip" data-placement="top" title="Delete">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
</form>

                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
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

     
    
    
<script>
function textFilter(data) {
    data.value = data.value.replace(/[^ .a-z]/ig, "");
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var alert = document.getElementById('alert-message');
    if (alert) {
        setTimeout(function() {
            alert.classList.add('alert-hidden');
        }, 3000); // Hide after 5 seconds
    }
});
</script>

    <?php
include('footer.php');
    ?>
    <?php } ?>