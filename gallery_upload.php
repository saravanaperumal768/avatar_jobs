 <?php
 error_reporting(0);
include('top.php');
// include('connection.php');
$job_create=1;
 ?>
 
 <div class="wrapper">
 <?php
include('left.php');
include('nav.php');
 ?>  
        <style>
  .btn a{
color :#fff;
  }
  .btn a:hover{
color :#000;
  }
  </style>
  <script type="text/javascript" src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
      <div class="content-page">
                <div class="container-fluid">
                <div class="row justify-content-center" >
                <a href="add_type_image.php" ><button class="btn btn-primary">Add Images Type  </button></a> &nbsp;
                <a href="add_category_image.php" ><button class="btn btn-primary">Add Images Category </button></a> 
                     <!--<button class="btn btn-primary" style="margin:0px 5px;"><a href="add_type_work.php" >Add Type of Work </a> </button> -->
                  </div>
                  <br>
             


                  <?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$gallery_image_query = mysqli_query($db, "SELECT * FROM gallery_image WHERE id='$id'");
$gallery_image = mysqli_fetch_assoc($gallery_image_query);
?>

<div class="row justify-content-center">
    <div style="margin-bottom:30px;">
        <div class="form_wrapper">
            <div class="form_container">
                <div class="title_container">
                    <h2>Add Images In Gallery</h2>
                </div>
                <div class="row clearfix">
                    <div>
                        <form name="gallery_form" id="gallery_form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($gallery_image['id']); ?>" />
                            <label> Name of the Image </label>  
                            <div class="input_field">
                                <span><i aria-hidden="true" class="fa fa-tasks"></i></span>
                                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($gallery_image['name']); ?>" placeholder="Name Of The Image"/>
                            </div>

                            <label>Category</label>
                            <div class="input_field select_option">
                                <select name="category" id="category">
                                <option value="0" <?php if ($gallery_image['category'] == '0') echo 'selected'; ?>>
                                        --------Select Category----------
                                    </option>
                                    <!-- Categories will be loaded here by PHP -->
                                    <?php
                                    $category_query = mysqli_query($db, "SELECT * FROM image_category WHERE status='Active'");
                                    while ($category = mysqli_fetch_array($category_query)) {
                                        $category_value = htmlspecialchars($category['category']);
                                        ?>
                                        <option value="<?php echo $category_value; ?>" <?php if ($gallery_image['category'] == $category_value) echo 'selected'; ?>>
                                            <?php echo $category_value; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="select_arrow"></div>
                            </div>

                            <label>Type</label>
                            <div class="input_field select_option">
                                <select name="type" id="type">
                                
                                    <option value="0">--------Select Type----------</option>

                                    <?php

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Execute a query to fetch active image types
    $type_query = mysqli_query($db, "SELECT * FROM image_type WHERE status='Active'");

    // Iterate through the results and populate the options
    while ($type = mysqli_fetch_array($type_query)) {
        $type_value = htmlspecialchars($type['type']);
        ?>
        <option value="<?php echo $type_value; ?>" <?php if ($gallery_image['type'] == $type_value) echo 'selected'; ?>>
            <?php echo $type_value; ?>
        </option>
        <?php
    }
}
?>

                                  

                                    

                                 
                                </select>
                                <div class="select_arrow"></div>
                            </div>




                            <label> Client</label>
                            <div class="input_field select_option">
                                <select name="client" id="client">
                                    <option value="0" <?php if ($gallery_image['client'] == '0') echo 'selected'; ?>>
                                        --------Select Client----------
                                    </option>
                                    <?php
                                    $client_query = mysqli_query($db, "SELECT * FROM clients WHERE status='1'");
                                    while ($client = mysqli_fetch_array($client_query)) {
                                        $client_name = htmlspecialchars($client['name']);
                                    ?>
                                        <option value="<?php echo $client_name; ?>" <?php if ($gallery_image['client'] == $client_name) echo 'selected'; ?>>
                                            <?php echo $client_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="select_arrow"></div>
                            </div>

                            <label>Status</label>
                            <div class="input_field select_option">
                                <select class="form-control mb-3" name="status" id="status">
                                    <option value="Active" <?php if ($gallery_image['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                    <option value="Inactive" <?php if ($gallery_image['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                </select>
                                <div class="select_arrow"></div>
                            </div>

                            <div class="input_field"> 
                                <label>Select Image</label> 
                                <div class="field" align="left">
                                    <?php
                                    $selected_file = isset($gallery_image['image_file']) ? $gallery_image['image_file'] : '';

                                    if (empty($selected_file)) {
                                        echo '<h3>Upload your File</h3>';
                                        // Allow only one file to be selected
                                        echo '<input type="file" id="files" name="pdfFiles[]" />';
                                    } else {
                                        $fileLinks = explode(',', $selected_file); // Assuming files are separated by commas
                                        if (!empty($fileLinks)) {
                                            echo '<p>Current file(s):</p>';
                                            foreach ($fileLinks as $fileLink) {
                                                $fileLink = trim($fileLink); 
                                                echo '<input type="hidden" name="pdfFiles[]" id="current" value="' . htmlspecialchars($fileLink) . '" />';
                                                if (!empty($fileLink)) {
                                                    echo '<a href="' . htmlspecialchars($fileLink) . '" target="_blank">Image File</a><br>';
                                                }
                                            }
                                        }
                                        echo '<p>Upload a new file (if any):</p>';
                                        // Allow only one file to be selected
                                        echo '<input type="file" id="file" name="pdfFiles[]" />';
                                    }
                                    ?>
                                </div>
                            </div>


                            <div class="text-center" style="margin:0 auto;">
           
                                <button class="btn btn-primary" type="submit" id="btn">Submit  </button>
                                &nbsp; &nbsp;
                                

                                <button type="button" class="btn btn-danger" onclick="location.replace('gallery_list.php')" aria-label="Go back">Back</button>
                                 <!-- <button class="button" id="btn" name="btn" type="submit">Submit</button> -->
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#category').change(function() {
        var category = $(this).val();
       // alert("Sending AJAX Request for Category: " + category);

        $.ajax({
            url: 'get_types.php',
            type: 'POST',
            data: {category: category},
            success: function(response) {
               // alert("AJAX Response: " + response);
                $('#type').html(response);
            },
            error: function(xhr, status, error) {
                alert("AJAX Error: " + error);
            }
        });
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn').on('click', function(event) {
            event.preventDefault(); // Prevent default form submission

            var inputFieldNames = ['name', 'category', 'type', 'client', 'status'];
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
                $('#gallery_form').attr('action', "upload_gallery_image.php");
                $('#gallery_form').submit();
            }
        });
    });
    </script>

    <!-- Wrapper End-->

    <?php
include('footer.php');
    ?>