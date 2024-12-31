<?php
include('connection.php');

// if  isset($_POST['newCompletion']) {
//     $jobId = $_POST['jobId'];
//     $newDate = $_POST['date'];

//     echo $jobId;
//     echo $newDate;
// } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avatar Jobs</title>
    <link rel="shortcut icon" href="assets/images/logo/icon.png" />
    <style>
        body {
    font-family: sans-serif;
    min-height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    
   
    position: relative;
}
.survey-form {
    max-width: 500px;
    min-width: 350px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
}
  
h2 {
    text-align: center;
}
  
.form-group {
    margin-bottom: 20px;
    padding:10px;
}
  
label {
    display: block;
    margin: 10px ;
}
  
input[type="date"],
input[type="time"],
textarea, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
  
input[type="range"] {
    width: 100%;
}
  
button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
  

  
.attribute{
    position: absolute;
    bottom: 10px;
}
    </style>
</head>
<body>
<form class="survey-form" method="post" action="process_members.php">
        <?php $id = $_GET['id']; ?>
        <div class="form-group">
        <label for="date">Select Member to Update : </label>
            
        <select name="member_complete_id" class="select_box select_member">
                                            <?php
        
                                            $category = mysqli_query($db,"SELECT * FROM members ");
                                            // foreach ($category as $cat) {
                                        // $tat = $cat['name'];
                                        // echo $tat;
                                        while($cat = mysqli_fetch_array($category))
                                    {
                                        
                                        ?>
                                        
                                        <option value="<?php echo $cat['id'] ?>" ><?php echo $cat['fname'] ?></option>
                                            
                                        
                                        <?php  }?>
                                       
        </select> 
        
        <input type="hidden" id="assigned_by" name="assigned_by" value="<?php
                if (isset($_GET['logname'])) {
                    // Sanitize the input (username)
                    $logName = mysqli_real_escape_string($db, $_GET['logname']);
                    
                    // Fetch member's first name based on the provided username
                    $memberResult = mysqli_query($db, "SELECT fname FROM members WHERE username = '$logName'");
                    $memberRow = mysqli_fetch_assoc($memberResult);
                    
                    if ($memberRow) {
                        echo $memberRow['fname']; // Display the member's first name
                    } else {
                        echo 'No member found';
                    }
                } else {
                    echo 'No username provided';
                }

                ?>">

            <input type="hidden" id="jobId" name="jobId" value="<?php echo $_GET['id']; ?>">
        </div>
        <button type="submit">Submit</button>
    </form>
     
</body>
</html>