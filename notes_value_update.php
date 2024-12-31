<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['id1'];
    $notes_values = mysqli_real_escape_string($db, $_POST['notes_values']);

    // Prepare an update statement
    $sql = "UPDATE clients SET notes = '$notes_values' WHERE id = $client_id";
    
    if (mysqli_query($db, $sql)) {
        echo "<script>alert('Data updated successfully!');window.location.href='add_clients_details.php?id=$client_id&name_value=1';</script>";
    } 
    // Close connection
    mysqli_close($db);
}
?>
