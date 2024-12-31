<?php

include('connection.php');

$profile_id=$_REQUEST['profile_id'];
$clients_name=$_REQUEST['clients_name'];

$resume_file_name = $_FILES['profile_picture']['name'];
if (!empty($resume_file_name)) {
 
    $resume_files = $clients_name.time() . '_' . $resume_file_name;

    move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'client_dp/' . $resume_files);
    $target_directory = 'client_dp/';
    $resume_file = $target_directory . $resume_files;
} 
$sql = "UPDATE clients SET profile_picture = '$resume_file' WHERE id = '$profile_id'";

// echo $sql;
// exit;

if (mysqli_query($db, $sql)) {
    $message4 = "Profile Picture Updated";
    echo "<script type='text/javascript'>alert('$message4');window.location.href = 'add_clients.php';</script>";
}
?>