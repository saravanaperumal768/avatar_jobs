<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST["id1"];
    $field_names = $_POST["field_names"];
    $field_values = $_POST["field_values"];
    
    // Loop through the posted field names and values to construct the update query
    foreach ($field_names as $index => $fieldName) {
        $fieldValue = $field_values[$fieldName];
        
        // Construct the SQL update query
        $sqlUpdate = "UPDATE clients SET $fieldName = '$fieldValue' WHERE id = $client_id";
        
        // Execute the SQL update query
        if (!$db->query($sqlUpdate)) {
            echo "Error updating " . $fieldName . ": " . $db->error;
            exit;
        }
        
        // echo "Field Name: " . $fieldName . ", Field Value: " . $fieldValue . " - Updated Successfully<br>";
    }
    
    echo "<script>alert('Data updated successfully!');window.location.href='add_clients_details.php?id=$client_id&name_value=1';</script>";
}
?>