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
<form class="survey-form" method="post" action="process_date.php">
        <?php $id = $_GET['id']; ?>
        <div class="form-group">
            <label for="date">Enter Deadline Date:</label>
            <input type="date" id="date" name="date">
            <label for="date">Select Deadline Time:</label>
            <select name="timepicker">
                                
                              
                                 <option value="09:00-9.30 AM" selected="">09:00-9.30 AM</option>
                                <option value="09:30-10.00 AM" >09:30-10.00 AM</option>
                                
                                <option value="10:00-10:30 AM ">10:00-10:30 AM</option>
                                <option value="10:30-11:00 AM ">10:30-11:00 AM</option>
                                
                                <option value="11:00-11:30 AM">11:00-11:30 AM</option>
                                <option value="11:30-12:00 AM">11:30-12:00 AM</option>

                                <option value="12:00-12:30 PM">12:00-12:30 PM </option>
                                <option value="12:30-1:00 PM">12:30-1:00 PM</option>
                                <option value="1:00-1:30 PM">1:00-1:30 PM</option>
                                <option value="1:30-2:00 PM">1:30-02:00 PM</option>
                                <option value="02:00-2:30 PM">02:00-02:30 PM</option>
                                <option value="02:30-3:00 PM">02:30-03:00 PM</option>
                                <option value="03:00-3:30 PM">03:00-03:30 PM</option>
                                <option value="03:30-4:00 PM">03:30-04:00 PM</option>
                                <option value="04:00-4:30 PM">04:00-04:30 PM</option>
                                <option value="04:30-5:00 PM">04:30-05:00 PM</option>
                                <option value="05:00-5:30 PM">05:00-05:30 PM</option>
                                <option value="05:30-6:00 PM">05:30-06:00 PM</option>
                                <option value="6:00-06:30 PM">6:00-06:30 PM</option>
                                <option value="06:30-7:00 PM">06:30-7.00 PM</option>
                                <!-- <option value="06:00-6:30 PM">06:00-06:30 PM</option> -->
               
                        </select>
            <input type="hidden" id="jobId" name="jobId" value="<?php echo $_GET['id']; ?>">
        </div>
        <button type="submit">Submit</button>
    </form>
     
</body>
</html>