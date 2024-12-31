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

$career=1;  

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




// if (isset($_GET['id'])) {
   
//     $qualification_id = intval($_GET['id']);

   
//     $delete_query = "DELETE FROM qualifications WHERE id = '$qualification_id'";

//     if (mysqli_query($db, $delete_query)) {
//         echo 'success';
//     } else {
//         echo 'error';
//     }
// } else {
//     echo 'error';
// }

// if (mysqli_query($db, $sql)) {
//     echo "Record updated successfully.";
// } else {
//     echo "Error updating record: " . mysqli_error($db);
// }

		 
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

<style>
.alert-hidden {
    display: none;
}
.close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    float: right;
}
</style>

<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$destination = isset($_GET['destination']) ? mysqli_real_escape_string($db, $_GET['destination']) : '';
$careers_query = mysqli_query($db, "SELECT * FROM careers WHERE id='$id' AND destination='$destination'");
$careers = mysqli_fetch_assoc($careers_query);
?>


       
      <div class="content-page">

      
<div class="container-fluid">


        <div class="row">

        
            
            <div class="col-lg-12">
                     


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
            echo '<div id="alert-message" class="' . htmlspecialchars($alertClass) . '">';
            echo '<span>' . htmlspecialchars($message) . '</span>';
            echo '<button type="button" id="close-btn" class="close" aria-label="Close">&times;</button>';
            echo '</div>';
        }
    }
?>
                <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <!-- <h4 class="card-title">Careers List</h4> -->

                        <?php
// Check if an ID is set (you can replace 'id' with the appropriate key if needed)
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    echo '<h4 class="card-title">Careers Edit</h4>';
} else {
    echo '<h4 class="card-title">Careers ADD</h4>';
}
?>
                     
                     </div>
                
                  </div>

                  <form   method="post" enctype="multipart/form-data" id="careers_form" name="careers_form" >  
                        <div class="card-body">
                        <!-- action="iteration_data.php" method="POST" -->
                     <form   method="post">

                     <input name="id" type="hidden" id="id" value="<?php echo htmlspecialchars($careers['id']); ?>" />
                        <div class="row"> 
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Job Destination</label>
                                    
                                    <input type="text" class="form-control" id="destination" name="destination"  value="<?php echo htmlspecialchars($careers['destination']); ?>">
                                    </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Skills</label>
                                    
                                    <input type="text" class="form-control" id="skills" name="skills"  value="<?php echo htmlspecialchars($careers['skills']); ?>">
                                    </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Experience</label>
                                    
                                    <input type="text" class="form-control" id="experience" name="experience"   value="<?php echo htmlspecialchars($careers['experience']); ?>">
                                    </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputText1">Location</label>
                                    
                                    <input type="text" class="form-control" id="location" name="location"  value="<?php echo htmlspecialchars($careers['location']); ?>">
                                    </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control mb-3" name="status" id="status">
                                <option value="Active" <?php if ($careers['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                <option value="Inactive" <?php if ($careers['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                           
                        </div>
                        <div class="row"> 
                                 
                        <div class="col-md-12 col-lg-12">

                        <div class="form-group" id="inputContainer1">
                            <label>Qualifications</label>

                            <?php
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Sanitize input variables to prevent SQL injection
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $destination = isset($_GET['destination']) ? mysqli_real_escape_string($db, $_GET['destination']) : '';

    // Query to fetch qualifications
    $careers_query = mysqli_query($db, "SELECT * FROM qualifications WHERE careers_id='$id' AND destination='$destination'");

    // Loop through the results and create an input field for each qualification
    while ($qualification = mysqli_fetch_assoc($careers_query)) {
        echo '<div class="qualification-row" style="display: flex; align-items: center; margin-bottom: 10px;" id="row-' . $qualification['id'] . '">';
        echo '<input type="text" class="form-control" name="qualifications[]" id="qualifications" value="' . htmlspecialchars($qualification['qualifications']) . '" style="height: 45px; margin-right: 10px;" />';
        echo '<input type="hidden" class="form-control" name="qualifications_id[]" id="qualifications_id" value="' . htmlspecialchars($qualification['id']) . '" />';
        echo '<button type="button" class="delete-btn" data-id="' . $qualification['id'] . '" style="background: none; border: none; cursor: pointer;">';
        echo '<i class="fa fa-trash" aria-hidden="true" style="color: red;"></i>'; // FontAwesome Trash Icon
        echo '</button>';
        echo '</div>';
    }
} else {
    // Output an empty input field if no qualifications are found
    echo '<input type="text" class="form-control" name="qualifications[]" id="qualifications" style="height: 45px; margin-bottom: 10px;" />';
}
?>                     
                        </div>
                        <button type="button" id="increaseInputBtn1" class="btn btn-primary">Add Line</button>
                        <button type="button" id="decreaseInputBtn1" class="btn btn-danger">Remove Line</button>

                        <div class="form-group" id="inputContainer">
                            <label>Responsibilities</label>

                            <?php
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Sanitize input variables to prevent SQL injection
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $destination = isset($_GET['destination']) ? mysqli_real_escape_string($db, $_GET['destination']) : '';

   
    $careers_query = mysqli_query($db, "SELECT * FROM responsibilities WHERE careers_id='$id' AND destination='$destination'");

    // Loop through the results and create an input field for each qualification
    // while ($responsibilities = mysqli_fetch_assoc($careers_query)) {
    //     echo '<input type="text" class="form-control" name="responsibilities[]" id="responsibilities" value="' . htmlspecialchars($responsibilities['responsibilities']) . '" style="height: 45px; margin-bottom: 10px;" />
    //     <input type="hidden" class="form-control" name="responsibilities_id[]" id="responsibilities_id" value="' . htmlspecialchars($responsibilities['id']) . '" style="height: 45px; margin-bottom: 10px;" />';
    // }

    while ($responsibilities = mysqli_fetch_assoc($careers_query)) {
        echo '<div class="responsibilities-row" style="display: flex; align-items: center; margin-bottom: 10px;" id="row-' . $responsibilities['id'] . '">';
        echo '<input type="text" class="form-control" name="responsibilities[]" id="responsibilities" value="' . htmlspecialchars($responsibilities['responsibilities']) . '" style="height: 45px; margin-right: 10px;" />';
        echo '<input type="hidden" class="form-control" name="responsibilities_id[]" id="responsibilities_id" value="' . htmlspecialchars($responsibilities['id']) . '" />';
        echo '<button type="button" class="delete-btn1" data-id1="' . $responsibilities['id'] . '" style="background: none; border: none; cursor: pointer;">';
        echo '<i class="fa fa-trash" aria-hidden="true" style="color: red;"></i>'; // FontAwesome Trash Icon
        echo '</button>';
        echo '</div>';
    }
} else {
    // Output an empty input field if no qualifications are found
    echo '<input type="text" class="form-control" name="responsibilities[]" id="responsibilities" style="height: 45px; margin-bottom: 10px;" />';
}
?>


                            
                        </div>
                        <button type="button" id="increaseInputBtn" class="btn btn-primary">Add Line</button>
                        <button type="button" id="decreaseInputBtn" class="btn btn-danger">Remove Line</button>

                        <div class="input_field"> 
                                <label>Select Image</label> 
                                <div class="field" align="left">
    <?php
    $selected_file = isset($careers['destination_icon']) ? $careers['destination_icon'] : '';

    if (empty($selected_file)) {
        echo '<h3>Upload your Destination Icon (Images or GIFs only)</h3>';
        // Allow only image and GIF file types
        echo '<input type="file" id="files" name="pdfFiles[]" accept=".jpg,.jpeg,.png,.gif,.webp" />';
    } else {
        $fileLinks = explode(',', $selected_file); // Assuming files are separated by commas
        if (!empty($fileLinks)) {
            echo '<p>Current Destination Icon(s):</p>';
            foreach ($fileLinks as $fileLink) {
                $fileLink = trim($fileLink); 
                echo '<input type="hidden" name="pdfFiles[]" id="current" value="' . htmlspecialchars($fileLink) . '" />';
                if (!empty($fileLink)) {
                    echo '<a href="' . htmlspecialchars($fileLink) . '" target="_blank">Destination Icon</a><br>';
                }
            }
        }
        echo '<p>Upload a new file (Images or GIFs only, if any):</p>';
        // Allow only image and GIF file types
        echo '<input type="file" id="file" name="pdfFiles[]" accept=".jpg,.jpeg,.png,.gif,.webp" />';
    }
    ?>
</div>

                            </div>
                        </div>
                    </div>

                        
                 

                        <div class="d-flex justify-content-end mt-4">

                                        <?php
                            // Check if an ID is set (you can replace 'id' with the appropriate key if needed)
                            $id = isset($_GET['id']) ? $_GET['id'] : null;

                            if ($id) {
                                echo '<button type="submit" id="btn" class="btn btn-secondary" aria-label="Reset form and save">Update</button>';
                            } else {
                                echo '<button type="submit" id="btn" class="btn btn-secondary" aria-label="Reset form and save">Submit</button>';
                            }
                            ?>
                            &nbsp; &nbsp; &nbsp;
                            <button type="button" class="btn btn-danger" onclick="window.location.href='career.php'" aria-label="Go back">Back</button>

                        </div>
                            <!-- <button type="submit" class="btn btn-danger">Edit</button>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        
                     </form>
                  </div>
                  </div>

                  <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Career Page Job List</h5>
                              
                                </div>
                                <div class="table-responsive ">

                                

                             
                                    <table class="table data-table mb-0 " >
                                    
                                        <thead class="table-color-heading">
                                            <tr class="">
                                           
                                                <th scope="col">Destination  </th>
                                                <th scope="col">Skills  </th>
                                                <th scope="col">experiences  </th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Icon</th>
                                                <th scope="col">Status</th>
                                                
                                 
                                                <th scope="col" > 
                                                    Action    </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                //   WHERE members = '$name_member_id'
                              
                                $sql2 = "SELECT * FROM careers ORDER BY id desc";


                                //   echo $sql2;
                                //   exit;
                                    $result2=mysqli_query($db,$sql2);
                                    $num=1;
                                    while ($db_field2 = mysqli_fetch_array($result2)) {
                                       $id =$db_field2["id"];
                                       $destination = $db_field2["destination"];
                                       $skills = $db_field2["skills"];
                                       $experience = $db_field2["experience"];
                                       $location= $db_field2["location"];
                                       $destination_icon= $db_field2["destination_icon"];
                                       $status= $db_field2["status"];
                                   
                                    
                                        ?>  
                           
                                            <tr class="white-space-no-wrap">
                                          
                                            <!-- <td><?php echo $db_field2["id"] ?> </td> -->

                                            
                                            <input name="img" type="hidden" id="img" value="<?php echo $_REQUEST["id"]; ?>" />
                                                
                                         <td><?php echo $db_field2["destination"] ?> </td>
                                         <td><?php echo $db_field2["skills"] ?> </td>
                                         <td><?php echo $db_field2["experience"] ?> </td>
                                         <td><?php echo $db_field2["location"] ?> </td>
                                         <td>
                                        
                                         <?php if (empty($db_field2["destination_icon"])) {
                                                  ?> 
                                                    <p style="color:red;"> No Data </p>
                                               <?php }else{?>
                                                    
                                                    <div class="active-project-1 d-flex align-items-center mt-0 ">
                                                        <div class="h-avatar is-medium">
                                                         <img class="avatar rounded-circle"  src="<?php echo $db_field2["destination_icon"]?>">
                                                            </div>
                                                     
                                                    </div>
                                                <?php }?>
                                        
                                        </td>
                                         <td><?php echo $db_field2["status"] ?> </td>
                                   
                                    
                                                                                     
                                               <td>
                                                    <div class="d-flex align-items-center">
                                                 
                                                        <?php
                                                        echo "<a href='career.php?id=$id&destination=$destination' target='_parent'>";
                                                        ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                        <?php echo "</a>" ?>



                                                        <button type="button" class="badge bg-danger" style="border:none;" name="delete_job" data-id="<?php echo intval($db_field2['id']); ?>" data-toggle="tooltip" data-placement="top" title="Delete" data-target="#confirmDeleteModal" data-toggle="modal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                      </button>



                                                          
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
document.addEventListener('DOMContentLoaded', function () {
    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Handle button click
    document.querySelectorAll('button[name="delete_job"]').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            // Show confirmation modal
            $('#confirmDeleteModal').modal('show');
            
            // Handle confirmation click
            document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                // AJAX request to delete the record
                $.ajax({
                    url: 'delete_career.php',
                    type: 'POST',
                    data: { id: id },
                    success: function (response) {
                        if (response.success) {
                        // Redirect to a new page with a success message in the URL
                        window.location.href = 'career.php?success=deleted';
                    } else {
                        alert('Failed to delete record.');
                    }

                    },
                    error: function () {
                        alert('Error occurred while deleting the record.');
                    }
                });
            });
        });
    });
});
</script>


<!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

   



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn').on('click', function(event) {
            event.preventDefault(); // Prevent default form submission

            var inputFieldNames = ['destination', 'skills', 'experience', 'location', 'qualifications','responsibilities','status'];
            var isValid = true;

            for (var i = 0; i < inputFieldNames.length; i++) {
                var fieldName = inputFieldNames[i];
                var fieldValue = $('#' + fieldName).val().trim();
                var isFieldInvalid = (fieldValue === '' || fieldValue === '0');

                if (isFieldInvalid) {
                    $('#' + fieldName).focus();
                    $('#' + fieldName).addClass('is-invalid');
                    isValid = false;
                    break; // Exit loop on first invalid field
                } else {
                    $('#' + fieldName).removeClass('is-invalid');
                }
            }

            if (isValid) {
                var selectedFile = $('#files').val();
            var currentFiles = $('#current').length;

            if (currentFiles === 0 && selectedFile === '') {
                alert('Please upload an image file.');
                isValid = false;
                $('#file').focus();
            }
            }

            if (isValid) {
                $('#careers_form').attr('action', "upload_careers.php");
                $('#careers_form').submit();
            }
        });
    });
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var alert = document.getElementById('alert-message');
    var closeBtn = document.getElementById('close-btn');
    
    // Hide the alert automatically after 3 seconds
    if (alert) {
        setTimeout(function() {
            alert.classList.add('alert-hidden');
        }, 3000); // Hide after 3 seconds
    }

    // Add close functionality to the close button
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            alert.classList.add('alert-hidden');
        });
    }
});
</script>

    

    
<script>
    document.getElementById('increaseInputBtn1').addEventListener('click', function() {
        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.className = 'form-control';
        newInput.name = 'qualifications[]';
        newInput.style.height = '45px';
        newInput.style.marginBottom = '10px';
        document.getElementById('inputContainer1').appendChild(newInput);
    });

    document.getElementById('decreaseInputBtn1').addEventListener('click', function() {
        var inputContainer1 = document.getElementById('inputContainer1');
        var inputs = inputContainer1.getElementsByTagName('input');
        if (inputs.length > 1) {
            inputContainer1.removeChild(inputs[inputs.length - 1]);
        }
    });

    document.getElementById('increaseInputBtn').addEventListener('click', function() {
        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.className = 'form-control';
        newInput.name = 'responsibilities[]';
        newInput.style.height = '45px';
        newInput.style.marginBottom = '10px';
        document.getElementById('inputContainer').appendChild(newInput);
    });

    document.getElementById('decreaseInputBtn').addEventListener('click', function() {
        var inputContainer = document.getElementById('inputContainer');
        var inputs = inputContainer.getElementsByTagName('input');
        if (inputs.length > 1) {
            inputContainer.removeChild(inputs[inputs.length - 1]);
        }
    });

</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->

<script>
document.querySelectorAll('.delete-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        const qualificationId = this.getAttribute('data-id');
       // alert("Button clicked. Qualification ID: " + qualificationId);

        $.ajax({
            url: 'delete_qualification.php',  // Ensure this path is correct
            type: 'POST',
            data: { id: qualificationId },
            success: function(response) {
               // alert("AJAX success. Response: " + response.trim());
                if (response.trim() === 'success') {
                    alert("Qualification deleted successfully.");
                    // Remove the row from the DOM
                    document.getElementById('row-' + qualificationId).remove();
                } else {
                    alert("Error deleting qualification: " + response);
                }
            },
            error: function(xhr, status, error) {
                alert("AJAX error: " + error);
            }
        });
    });
});

</script>

<script>
document.querySelectorAll('.delete-btn1').forEach(function(button) {
    button.addEventListener('click', function() {
        const responsibilitiesId = this.getAttribute('data-id1');
       // alert("Button clicked. Qualification ID: " + qualificationId);

        $.ajax({
            url: 'delete_responsibilities.php',  // Ensure this path is correct
            type: 'POST',
            data: { id: responsibilitiesId },
            success: function(response) {
               // alert("AJAX success. Response: " + response.trim());
                if (response.trim() === 'success') {
                    alert("Responsibilities deleted successfully.");
                    // Remove the row from the DOM
                    document.getElementById('row-' + responsibilitiesId).remove();
                } else {
                    alert("Error deleting qualification: " + response);
                }
            },
            error: function(xhr, status, error) {
                alert("AJAX error: " + error);
            }
        });
    });
});

</script>






    <?php
include('footer.php');
    ?>
    <?php } ?>