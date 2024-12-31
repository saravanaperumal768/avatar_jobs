<?php
// error_reporting(0);


include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberID = $_POST['member_id'];
    $old_pass = substr(md5($_REQUEST['old_pass']), 25);
    $new_pass = substr(md5($_REQUEST['new_pass']), 25);
    $con_pass = substr(md5($_REQUEST['con_pass']), 25); // Get the hashed value of confirmed password

    $pass_res = mysqli_query($db, "SELECT * FROM members WHERE id = $memberID");
    $num = mysqli_num_rows($pass_res);

    if ($num > 0) {
        $pre_det = mysqli_fetch_array($pass_res);
        // Verify old password
        if ($old_pass === $pre_det['password']) {
            // Check if the new password matches the confirmed password
            if ($new_pass === $con_pass) {
                // Update password if confirmed
                $qry = "UPDATE members SET password='$new_pass' WHERE id ='".$pre_det['id']."'";
                $result = mysqli_query($db, $qry);
                
                if ($result) {
                    $message = "Password Changed";
                    echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
                } else {
                    $message = "Failed to change password";
                    echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
                }
            } else {
                $message = "New Passwords do not match";
                echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
            }
        } else {
            $message = "Incorrect Old Password ";
            echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
        }
    } else {
        $message = "Enter Valid Details";
        echo "<script type='text/javascript'>alert('$message'); window.location.href = 'edit_profile.php';</script>";
    }
}





?>

