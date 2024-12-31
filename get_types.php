<?php
include("connection.php");

if (isset($_POST['category'])) {
    $category = mysqli_real_escape_string($db, $_POST['category']);
    $type_query = mysqli_query($db, "SELECT * FROM image_type WHERE category='$category' AND status='Active'");
    echo '<option value="0">--------Select Type----------</option>';
    while ($type = mysqli_fetch_array($type_query)) {
        $type_value = htmlspecialchars($type['type']);
        echo '<option value="' . $type_value . '">' . $type_value . '</option>';
    }
} else {
    echo "No Category Received.";
}
?>

