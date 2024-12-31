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


<style>


.input-switch{
	display: none;
}

.label-switch{
	display: inline-block;
	position: relative;
}

.label-switch::before, .label-switch::after{
	content: "";
	display: inline-block;
	cursor: pointer;
	transition: all 0.5s;
}

.label-switch::before {
    width: 3em;
    height: 1em;
    border: 1px solid #757575;
    border-radius: 4em;
    background: #888888;
}

.label-switch::after {
    position: absolute;
    left: 0;
    top: -20%;
    width: 1.5em;
    height: 1.5em;
    border: 1px solid #757575;
    border-radius: 4em;
    background: #ffffff;
}

.input-switch:checked ~ .label-switch::before {
    background: #00a900;
    border-color: #008e00;
}

.input-switch:checked ~ .label-switch::after {
    left: unset;
    right: 0;
    background: #00ce00;
    border-color: #009a00;
}

.info-text {
	display: inline-block;
}


</style>



 <?php
 include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field_name = $_POST["field_name"];
    $field_data = $_POST["field_data"];
    $id1 = $_POST["id1"];

    $sql_check = "DESCRIBE clients";
    $result = $db->query($sql_check);
    $field_exists = false;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row["Field"] == $field_name) {
                $field_exists = true;
                break;
            }
        }
    }

    if ($field_exists) {
        echo "<script> alert('$field_name Field Name Already Exists');</script>";

    } else {

    // SQL to insert field name and data
    $sql = "ALTER TABLE clients ADD $field_name VARCHAR(255)";
   
    if ($db->query($sql) === TRUE) {
        $sql = "UPDATE clients SET $field_name = '$field_data' WHERE id = '$id1'";
        
        if ($db->query($sql) === TRUE) {
            echo "<script> alert(' $field_name Field and Data Updated successfully!');</script>";
        } 
    } 
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
</style>



<div class="content-page">
    <div class="container-fluid">
    <div class="row" style="padding:10px;">
            
            <div class="col-lg-12">
            <a href="add_clients.php"><button  class="btn btn-success" >Back</button>  </a>
            </div>   
    </div>  
    
    <div class="row">
    <div class="col-lg-6">
                
                <div class="card">
                
                    <div class="card-body">
                        
                        <form action="profile_picture_update.php" method="post" enctype="multipart/form-data">
                           <label> Profile Picture  </label><br>
                           <?php
                            $client_id = $_REQUEST["id"];
                            $sql = "Select * from clients where id='$client_id'";
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $client = $result->fetch_assoc();
                                $clients_name = $client['name'];
                                $clients_profile_picture= $client['profile_picture'];
                                ?>

                           <input type="hidden" name="profile_id" value="<?php echo $client_id; ?>" >
                           <input type="hidden" name="clients_name" value="<?php echo $clients_name; ?>" >
                           <input type="file" name="profile_picture" style="border:1px solid #fff;" required>
                           <br>
                            <?php 
                            if(!empty($clients_profile_picture)){ ?>
                            <img src="<?php echo $clients_profile_picture; ?>" width="270">
                            <br>
                            <br>
                            <?php
                            
                            }
                            ?>

                            <button type="submit" class="btn btn-success" name="update" value="Update" style="background:green;">Update</button>
                            <?php } ?>


                        </form>

                        <div class="card-body">
                        
                     
                    </div>
                    </div>
                </div>
            </div>
    </div>
        <div class="row">

    
            
            <div class="col-lg-6">
                
                <div class="card">
                
                    <div class="card-body">
                        <div class="header-title">
                            <h6 class="card-title">Details of 
                                <?php
                                $name_value = $_GET["name_value"];
                                if (empty($name_value)) {
                                    echo '<span style="color:red;">' . $_REQUEST["name"] . '</span>';
                                } else {
                                    $client_id = $_REQUEST["id"];
                                    $sqlData1 = "SELECT * FROM clients WHERE id = $client_id";
                                    $resultData1 = $db->query($sqlData1);
                                    if ($resultData1->num_rows > 0) {
                                        $row = $resultData1->fetch_assoc();
                                        $client_name = $row['name'];
                                        echo '<span style="color:red;">' . $client_name . '</span>';
                                    }
                                }
                                ?>
                            </h6>
                        </div>
                        <form action="update_clients_details.php" method="post">
    <?php
    $client_id = $_REQUEST["id"];
    $sql = "SHOW COLUMNS FROM clients WHERE Field != 'id' AND Field != 'enddate' AND Field != 'status' AND Field != 'address2' AND Field != 'address3' AND Field != 'notes'";
    $result = $db->query($sql);
    $firstFieldSkipped = false;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fieldName = $row['Field'];
            
            if (!$firstFieldSkipped) {
                // Skip the first field
                $firstFieldSkipped = true;
                continue;
            }
            
            $sqlData = "SELECT $fieldName FROM clients WHERE id = $client_id";
            $resultData = $db->query($sqlData);
            $rowData = $resultData->fetch_assoc();
            $fieldValue = $rowData[$fieldName];
            ?>
            <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
            <div class="form-group">
                <label for="<?php echo $fieldName ?>" style="padding-top:10px;text-transform:capitalize;"><?php echo $fieldName ?></label>
                <input type="hidden" name="field_names[]" value="<?php echo $fieldName ?>">
                <input type="text" class="form-control" id="<?php echo $fieldName ?>" name="field_values[<?php echo $fieldName ?>]" value="<?php echo $fieldValue ?>">
            </div>
        <?php
        }
    }
    ?>
    <button type="submit" class="btn btn-success" name="update" value="Update" style="background:green;">Update</button>
</form>


                        <div class="card-body">
                        <tr>

                        <?php
                            $client_id = $_REQUEST["id"];
                            $sql = "Select * from clients where id='$client_id'";
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $client = $result->fetch_assoc();
    
                                // Access the client data
                                $id = $client['id'];
                                $status =$client["status"];
                                ?>
                               
                            <p>Status </p>
                            <td height="32" align="left" class="generalfont" style="background:#fff;" >
                                    <input type="hidden" name="styleid_status_<?php echo $id; ?>" id="styleid_status_<?php echo $id; ?>" value="<?php echo $id; ?>">
                                    <input type="hidden" name="status_<?php echo $id; ?>" id="statusInput_<?php echo $id; ?>" value="<?php echo $status; ?>">
                                    <div align="left" style="margin-left:10px;padding:10px; background:#fff;">
                                        <span class="style54" style="color: black;padding:5px;line-height: 25px;">
                                            <input class='input-switch' type="checkbox" id="demo_<?php echo $id; ?>" <?php echo $status == 1 ? 'checked' : ''; ?> onchange="updateStatus(this)"/> <!-- Set checkbox state based on PHP variable -->
                                            <label class="label-switch" for="demo_<?php echo $id; ?>"></label>
                                           
                                        </span>
                                    </div>
                                </td>
                        </tr>
                        <?php } ?>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h5 class="card-title">ADD Field of 
                                <?php
                                $name_value = $_GET["name_value"];
                                if (empty($name_value)) {
                                    echo '<span style="color:red;">' . $_REQUEST["name"] . '</span>';
                                } else {
                                    $client_id = $_REQUEST["id"];
                                    $sqlData1 = "SELECT * FROM clients WHERE id = $client_id";
                                    $resultData1 = $db->query($sqlData1);
                                    if ($resultData1->num_rows > 0) {
                                        $row = $resultData1->fetch_assoc();
                                        $client_name = $row['name'];
                                        echo '<span style="color:red;">' . $client_name . '</span>';
                                    }
                                }
                                ?>
                            </h5>
                        </div>
                        <div class="header-action">
                            <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false">
                                <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </i>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
                            <div class="row">
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputText1">Field Name</label>
                                        <input type="text" class="form-control" id="clientname" name="field_name" required="">
                                    </div>
                                    <span style="color:red;">Don't use space or ;/-''"" [Instead of Space Use _]</span>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="field_type">Field Type</label>
                                    <select class="form-control" id="field_type" name="field_type">
                                        <option value="text">Text</option>
                                        <option value="date">Date</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                        <label for="field_data">Data</label>
                                        <input type="text" class="form-control" id="field_data" name="field_data">
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12" >
                                    <button type="submit" class="btn btn-success" style="background:green;">ADD</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- ------------------------------------------------------- -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h5 class="card-title">Important Notes for  
                                <?php
                                $name_value = $_GET["name_value"];
                                if (empty($name_value)) {
                                    echo '<span style="color:red;">' . $_REQUEST["name"] . '</span>';
                                } else {
                                    $client_id = $_REQUEST["id"];
                                    $sqlData1 = "SELECT * FROM clients WHERE id = $client_id";
                                    $resultData1 = $db->query($sqlData1);
                                    if ($resultData1->num_rows > 0) {
                                        $row = $resultData1->fetch_assoc();
                                        $client_name = $row['name'];
                                        echo '<span style="color:red;">' . $client_name . '</span>';
                                    }
                                }
                                ?>
                            </h5>
                        </div>
                        <div class="header-action">
                            <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false">
                                <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </i>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="notes_value_update.php">
                            <input name="id1" type="hidden" id="id1" value="<?php echo $_REQUEST["id"]; ?>" />
                            <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <?php 
                                $client_id = $_REQUEST["id"];
                                  $sqlData = "SELECT * FROM clients WHERE id = $client_id";
                                 
                                  $resultData = mysqli_query($db, $sqlData);
                                    if ($resultData) {
                                        // Check if any rows were returned
                                        if (mysqli_num_rows($resultData) > 0) {
                                            // Fetch the result as an associative array
                                            $row = mysqli_fetch_assoc($resultData);
                                            
                                            $note_values = $row['notes'];
                                           
                                        }
                                     }
                                ?>
                                    <div class="form-group">
                                        <label for="exampleInputText1">Notes</label>
                                        <textarea id="editor1" name="notes_values" rows="4" cols="50">
                                        <?php echo $note_values ?>
                                            </textarea>
                                            <script type="text/javascript" src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script> 
                                            <script type="text/javascript">
                                  var editor = CKEDITOR.replace( 'editor1' );

                                // The "change" event is fired whenever a change is made in the editor.
                                editor.on( 'change', function( evt ) {
                                    // getData() returns CKEditor's HTML content.
                                  console.log( 'This is what you typed ' + evt.editor.getData() + typeof evt.editor.getData() );
                                    console.log( 'Total bytes: ' + evt.editor.getData().length );
                                  $('#hiddedn input').val(evt.editor.getData());
                                });
                                </script>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-12 col-lg-12" >
                                    <button type="submit" class="btn btn-success" style="background:green;">Update Notes</button>
                                </div>
                            </div>
                        </form>

                        
                    </div>
                   
                </div>
            </div>
           
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#field_type').change(function(){
            var fieldType = $(this).val();
            
            if(fieldType == 'date'){
                $('#field_data').attr('type', 'date');
            } else {
                $('#field_data').attr('type', 'text');
            }
        });
    });
</script>

<script>
function updateStatus(checkbox) {
    var status = checkbox.checked ? 1 : 0;
    var styleId = checkbox.id.split('_').pop(); // Extract style ID from checkbox ID
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'status_active_job.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Update status text if needed
            var infoText = document.querySelector('#statusInput_' + styleId);
            infoText.value = status;
            var infoTextDisplay = document.querySelector('.info-text');
            infoTextDisplay.innerHTML = status === '1' ? "Active" : "Inactive";
        }
    };
    xhr.send('style_id=' + styleId + '&status=' + status);
}

</script>


    <?php
include('footer.php');
    ?>
    <?php } ?>