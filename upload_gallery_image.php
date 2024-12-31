<?php
session_start();
include("connection.php");

$log_name = $_SESSION["uname"];

// Retrieve POST data
$name = isset($_POST['name']) ? mysqli_real_escape_string($db, $_POST['name']) : '';
$category = isset($_POST['category']) ? mysqli_real_escape_string($db, $_POST['category']) : '';
$type = isset($_POST['type']) ? mysqli_real_escape_string($db, $_POST['type']) : '';
$client = isset($_POST['client']) ? mysqli_real_escape_string($db, $_POST['client']) : '';
$status = isset($_POST['status']) ? mysqli_real_escape_string($db, $_POST['status']) : '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$cus_date = date("Y-m-d");
$targetDir = "gallery/";
$allowedFileTypes = array("jpg", "jpeg", "png", "gif", "webp", "mp4", "avi", "mov", "wmv", "mkv");

$uploadedFiles = [];
if (!empty($_FILES['pdfFiles']['name'][0])) {
    $fileCount = count($_FILES['pdfFiles']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        $originalFileName = $_FILES['pdfFiles']['name'][$i];
        $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
        $uniqueFileName = time() . '-' . $i . '.' . $fileType;
        $targetFile = $targetDir . $uniqueFileName;

        if (!in_array($fileType, $allowedFileTypes)) {
            echo "<script type='text/javascript'>alert('Sorry, only image and video files (JPG, JPEG, PNG, GIF, WEBP, MP4, AVI, MOV, WMV, MKV) are allowed.');</script>";
            error_log("Detected File Type: $fileType");
        } else {
            if (move_uploaded_file($_FILES['pdfFiles']['tmp_name'][$i], $targetFile)) {
                $uploadedFiles[] = $targetFile;
            } else {
                echo "<script type='text/javascript'>alert('Error uploading file. Please try again.');</script>";
            }
        }
    }
}


$fileLinksImploded = !empty($uploadedFiles) ? implode(',', $uploadedFiles) : '';

if ($fileLinksImploded) {
    if ($id > 0) {
        // Update existing record
        $sql = "UPDATE gallery_image SET 
                name='$name', 
                category='$category', 
                type='$type', 
                client='$client', 
                image_file='$fileLinksImploded', 
                update_by='$log_name', 
                status='$status', 
                updated_at='$cus_date' 
                WHERE id='$id'";
        $message = "updated";
    } else {
        // Insert new record
        $sql = "INSERT INTO gallery_image (name, category, type, client, image_file, create_by, status, created_at) 
                VALUES ('$name', '$category', '$type', '$client', '$fileLinksImploded', '$log_name', '$status', '$cus_date')";
        $message = "added";
    }
} else {
    if ($id > 0) {
        // Update existing record without image_file
        $sql = "UPDATE gallery_image SET 
                name='$name', 
                category='$category', 
                type='$type', 
                client='$client', 
                update_by='$log_name', 
                status='$status', 
                updated_at='$cus_date' 
                WHERE id='$id'";
        $message = "updated";
    }
}

$result = mysqli_query($db, $sql);

if (!$result) {
    die('Error: ' . mysqli_error($db));
}

// Redirect after successful operation
header("Location: gallery_list.php?success=$message");
exit();
?>
