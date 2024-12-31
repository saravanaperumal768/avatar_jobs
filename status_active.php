<?php
session_start();
include("connection.php");

if (isset($_POST['style_id']) && isset($_POST['status'])) {
    $styleId = mysqli_real_escape_string($db, $_POST['style_id']);
    $status = mysqli_real_escape_string($db, $_POST['status']);
    
    // Update status in the database
    $sql = "UPDATE members SET status = '$status' WHERE id = '$styleId'";
    if (mysqli_query($db, $sql)) {
        echo 'Status updated successfully';
    } 
} 
?>
