<?php
include("connection.php");



$db->close();
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    
    // Prepare SQL statement to select username
    $stmt = $db->prepare("SELECT username FROM members WHERE username = $username");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    // If username exists, return 'exists'; otherwise, return something else
    if ($stmt->num_rows > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }
    
    $stmt->close();
}
?>
