<?php
	  include("connection.php");
// Check if the form was submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberID = $_POST['member_id'];
    // Retrieve form data
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $userName = $_POST['uname'];
    $city = $_POST['cname'];
    $gender = $_POST['schedule'];
    $dob = $_POST['dob'];
    $doj = $_POST['doj'];
    $designation = $_POST['designation'];
    $job_location = $_POST['job_location'];
    
    $bankAccountDetails = $_POST['bank_account_details'];
    $address = $_POST['address'];

 // File upload handling
$targetDir = "members_img/"; // Directory where uploaded files will be stored
$extension = pathinfo($_FILES["imageUpload"]["name"], PATHINFO_EXTENSION); // Get file extension
$timestamp = time(); // Get the current timestamp
$newFileName = $timestamp . '.' . $extension; // Create a new unique filename

$targetFile = $targetDir . $newFileName; // Path of the renamed file

// Check if a file was uploaded
if (!empty($_FILES["imageUpload"]["name"])) {
    // File uploaded, perform file handling and update query
    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFile)) {
        // Continue with the update query including the file update
        $sql = "UPDATE members SET 
                fname = '$firstName', 
                lname = '$lastName',
                designation = '$designation',
                email = '$email',
                mobile = '$mobile', 
                username = '$userName', 
                city = '$city', 
                gender = '$gender', 
                dob = '$dob',
                doj = '$doj', 
                job_location = '$job_location', 
                bank_account_details = '$bankAccountDetails', 
                address = '$address', 
                profile_picture = '$targetFile' 
                WHERE id = $memberID";

        $result = mysqli_query($db, $sql);

        if ($result) {
            $message = "Records Updated";
            echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
        } else {
            $message = "Enter Proper Record";
            echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
        }
    } else {
        $message = "Error uploading file";
        echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
    }
} else {
    // No file uploaded, perform update without file handling
    $sql2 = "UPDATE members SET 
            fname = '$firstName', 
            lname = '$lastName',
            designation = '$designation', 
            email = '$email',
            mobile = '$mobile',
            username = '$userName', 
            city = '$city', 
            gender = '$gender', 
            dob = '$dob', 
            doj = '$doj', 
            job_location = '$job_location', 
            bank_account_details = '$bankAccountDetails', 
            address = '$address' 
            WHERE id = $memberID";
            // echo $sql2;
            // exit;
    $result2 = mysqli_query($db, $sql2);

    if ($result2) {
        $message = "Records are Updated";
        echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
    } else {
        // echo "Error updating record: " . mysqli_error($db);
        $message = "Enter Proper Record";
        echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
    }
}


    
}
?>
