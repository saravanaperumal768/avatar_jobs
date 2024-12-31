 <?php

 error_reporting(0);
 ob_start();
 session_start();
 include("connection.php");
 $password1=mysqli_real_escape_string($db,stripslashes($_SESSION["hacses156"]));
 $ip1=mysqli_real_escape_string($db,stripslashes($_SESSION["hacses157"]));
 $ldate1=mysqli_real_escape_string($db,stripslashes($_SESSION["hacses158"]));
 
   $selquery="select * from logs where pwd1='$password1' and ip1='$ip1' and ldate1='$ldate1'";
 //   echo $selquery;
 //   die;
 
   $result=mysqli_query($db,$selquery);
   $count=mysqli_num_rows($result);
   
   if($count==0)   {
   header("location: index.php");
   //mysqli_close();
 
 }
 elseif($count==1)
 {
 
 $client=1;  
 
 $log_name=$_SESSION["uname"];
 
 $name_member = "SELECT * FROM members WHERE username = '$log_name'";
 $result = mysqli_query($db, $name_member);
 
 if ($result) {
     // Check if any rows were returned
     if (mysqli_num_rows($result) > 0) {
         // Fetch the result as an associative array
         $row = mysqli_fetch_assoc($result);
         
         // Access the 'name' column from the result
         $name_member2 = $row['fname'];
         $name_member_id = $row['id'];
         
         // Output the name
         // echo $name_member;
         // die;
     }
 }
include('top.php');
// include('connection.php');
$job_create=1;
 ?>
 
 <div class="wrapper">
 <?php
include('left.php');
include('nav.php');
 ?>  
        <style>
  .btn a{
color :#fff;
  }
  .btn a:hover{
color :#000;
  }
  .ui.calendar .ui.table tr .link {
    cursor: pointer;
    color: #000;
}
.form_wrapper input[type="text"], .form_wrapper input[type="email"], .form_wrapper input[type="password"] {
color:#000;
}
.clockpicker-button.am-button{
  color:#000;
}
.clockpicker-button.pm-button{
  color:#000;
}
.ui.calendar .ui.table tr td.today {
    font-weight: 900;
    color: #8129d9;
}
  </style>


  <script type="text/javascript" src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>


<link rel="stylesheet" href="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css"></link>
   <link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
      <div class="content-page">
                <div class="container-fluid">
             <?php if($name_member_id=="1") { ?>
                  <div class="row justify-content-center" >
                    <button class="btn btn-primary"><a href="add_clients.php" >Add Clients </a> </button> &nbsp;
                    <button class="btn btn-primary"><a href="job_type.php" >Add Job Type </a> </button>
                     <button class="btn btn-primary" style="margin:0px 5px;"><a href="add_type_work.php" >Add Type of Work </a> </button>
                  </div>
                  <?php } ?>
                  <br>
                    <div class="row justify-content-center">
                            <div class="" style="margin-bottom:30px;">
                      <div class="form_wrapper">
                        <div class="form_container">
                          <div class="title_container">
                            <h2>Job Creation</h2>
                          </div>
                          <div class="row clearfix">
                            <div class="">
                            <form  action="upload.php" method="POST" enctype="multipart/form-data">
                                  <label> Choose Client </label>
                                    <div class="input_field select_option">
                                   <select name="client" id="clientInput">
                                            <?php
        
                                              $category2 = mysqli_query($db,"SELECT * FROM clients where status='1'");
                                            // foreach ($category as $cat) {
                                        // $tat = $cat['name'];
                                        // echo $tat;
                                        while($cat2 = mysqli_fetch_array($category2))
                                    {
                                        
                                        ?>
                                       
                                        <option value="<?php echo $cat2['name'] ?>" ><?php echo $cat2['name'] ?></option>
                                            
                                        
                                        <?php  }?>
                                        </select>
                                        <div class="select_arrow"></div>
                                  </div>
                                  
                                  <label> Name of the Job </label>  
                                  <div class="input_field">
                                  
                                  <span><i aria-hidden="true" class="fa fa-tasks"></i></span>
                                   <input type="text" id="jobName" name="job" placeholder="Name Of The Job" required />
                                 
                                 </div>
                                 
                                 
                                                                <label> Job Type </label> 
                                <div class="input_field select_option"> 
                         


                                            <select name="job_type">
                                             <option value="0" >Choose Job Type</option>
                                            <?php
                    
                                              $category = mysqli_query($db,"SELECT * FROM  job_type ");
                                              // foreach ($category as $cat) {
                                          // $tat = $cat['name'];
                                          // echo $tat;
                                          while($cat = mysqli_fetch_array($category))
                                      {
                                          
                                          ?>
                                          
                                          <option value="<?php echo $cat['job_type'] ?>" ><?php echo $cat['job_type'] ?></option>
                                              
                                          
                                          <?php  }?>
                                    
                                            </select>
                                        <div class="select_arrow"></div>
                                        
                                        
                                </div>
                                <!---------------------------------->
                                 
                                 
                                 <label> Assign To </label>
                                 <div class="input_field select_option">
                                
                                        <select name="members" id="membersSelect">
                                            <?php
        
                                            $category2 = mysqli_query($db,"SELECT * FROM members WHERE status='1' ");
                                            // foreach ($category as $cat) {
                                        // $tat = $cat['name'];
                                        // echo $tat;
                                        while($cat2 = mysqli_fetch_array($category2))
                                    {
                                        
                                        ?>
                                       
                                        <option value="<?php echo $cat2['id'] ?>" ><?php echo $cat2['fname'] ?></option>
                                            
                                        
                                        <?php  }?>
                                        </select>
                                        <!-- <input type="text" name="memberIdHidden" id="memberIdHidden" value=""> -->
                                    <div class="select_arrow"></div>
                                    
                                    
                                    
                                  </div>
                            
                               <div class="row"> 
                                     <div class="col-md-6 col-lg-6">
                                         <label> Date of Completion </label> 
                                          <div class="input_field" id="example2"> 
                                            <span><i aria-hidden="true" class="fa fa-calendar"></i></span>
                                          
                                          <input placeholder=" Date of Completion" type="text" name="completion"   id="completion" autocomplete="off" required="">
                                          </div>
                                      </div>
                                      <div class="col-md-6 col-lg-6">
                                         <label> Date of Post </label> 
                                          <div class="input_field" id="date_of_post"> 
                                            <span><i aria-hidden="true" class="fa fa-calendar"></i></span>
                                          
                                          <input placeholder=" Date of Post" type="text" name="Date_of_post" id="Date_of_post" autocomplete="off" >
                                          </div>
                                      </div>
                                  </div>
                                <input type="hidden" id="assigned_by" name="assigned_by" value="<?php
                                $sqlquery ="Select * from members Where username='$log_name'";
                                $results=mysqli_query($db,$sqlquery);
                                while($cat2 = mysqli_fetch_array($results)){

                                echo $cat2['fname'];
                                } ?>" >


                                    <div class="row"> 
                                    
                                      <div class="col-md-6 col-lg-6">
                                            <label> Start Time </label> 
                                            
                                            
                                            <div class="input_field "> 
                                               <?php
                                        date_default_timezone_set('Asia/Kolkata');
                                          $current_time = date('h:i A');
                                          ?>
                                            <input type="text"  id="timeInput" name="time_picker" autocomplete="off"  value="<?php echo $current_time; ?>" required="" >

                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <label> End Time </label> 
                                    
                                            <div class="input_field "> 
                                            <input type="text"  id="timeInput1" name="time_picker_end" autocomplete="off" required="" >
                                         
                                            </div>
                                        </div>
                                    </div>
                                    

                                
                                 <!-- ------------ -->
                                <label> Type of Work</label> 
                                <div class="input_field select_option"> 
                         


                                <select name="type_of_work">
                                
                                <?php
        
                                  $category = mysqli_query($db,"SELECT * FROM  type_of_work ");
                                  // foreach ($category as $cat) {
                              // $tat = $cat['name'];
                              // echo $tat;
                              while($cat = mysqli_fetch_array($category))
                               {
                              
                              ?>
                              
                              <option value="<?php echo $cat['name'] ?>" ><?php echo $cat['name'] ?></option>
                                  
                              
                              <?php  }?>
                        
                                </select>
                                        <div class="select_arrow"></div>
                                </div>
                                <!-- -------------- -->
                                <label> Number of Layout Ideas </label> 
                                    <div class="input_field select_option booking-frm"> 
                                    <div class="field-holder">
                                         <label for="schedule_type">
                                        <input type="radio" name="layout_ideas" id="schedule"  value="0">0
                                      </label>
                                      <label for="schedule_type">
                                        <input type="radio" name="layout_ideas" id="schedule"  value="1">1
                                      </label>
                                      <label for="schedule_type">
                                        <input type="radio" name="layout_ideas" id="schedule" value="2">2
                                      </label>
                                      <label for="schedule_type">
                                        <input type="radio" name="layout_ideas" id="schedule" value="3">3
                                      </label>
                                      <label for="schedule_type">
                                        <input type="radio" name="layout_ideas" id="schedule" value="4">4
                                      </label>
                                    </div>
                                    </div>

                                          <label> Color Options </label> 
                                    
                                            <div class="input_field"> 
                                            
                                            <input type="text" name="color_options"   >
                                           
                                            </div>

                                
                                <!-- -------------- -->
                                <div class="input_field"> 
                                  <div class="col-md-12 col-sm-12 booking-frm">
                                    <div class="field-holder">
                                      <label for="schedule_type">
                                        <input type="radio" name="schedule" id="schedule" checked="" value="Urgent">Urgent
                                      </label>
                                      <label for="schedule_type">
                                        <input type="radio" name="schedule" id="schedule" value="Not Urgent">Not Urgent
                                      </label>
                                    
                                    </div>
                                  </div>
                                 </div>

                                 <div class="input_field"> 
                                  <div class="col-md-12 col-sm-12 booking-frm">
                                    <div class="field-holder2">
                                      <label for="schedule_type">
                                        <input type="radio" name="schedule2" id="schedule" checked="" value="Important">Important
                                      </label>
                                      <label for="schedule_type">
                                        <input type="radio" name="schedule2" id="schedule" value="Not Important">Not Important
                                      </label>
                                    
                                    </div>
                                  </div>
                                 </div>

                                <div class="input_field"> 
                                    <label class=""> Reference </label> 
                                    <div class="field" align="left">
                                      <h3>Upload your Files</h3>
                                      <input type="file" id="files" name="pdfFiles[]" multiple />
                                    </div>
                                </div>
                                <h3 class="text-center">(OR) </h3>

                                <label> Reference Link </label>  
                                  <div class="input_field">
                                  
                                  
                                  <input type="text" name="reference_link" placeholder="Reference Link"  />
                                 </div>

                                <label> Notes and Other Details </label>  
                                <div class="input_field"> 
                                <!--<span><i aria-hidden="true" class="fa fa-envelope"></i></span>-->
                                  <textarea id="editor1" name="notes" rows="4" cols="50">

                                </textarea>

                                <script type="text/javascript">
                                  var editor = CKEDITOR.replace( 'editor1' );
                                
                                // The "change" event is fired whenever a change is made in the editor.
                                editor.on( 'change', function( evt ) {
                                    // getData() returns CKEditor's HTML content.
                                  console.log( 'This is what you typed ' + evt.editor.getData() + typeof evt.editor.getData() );
                                    console.log( 'Total bytes: ' + evt.editor.getData().length );
                                  $('#hiddedn input').val(evt.editor.getData());
                                });
                                </script>
                                </div>

                                <div class="text-center" style="margin:0 auto;">
                                <input class="button" type="submit" value="Submit" />
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                                
                            </div>
                        </div>
                        
                    
                        </div>
                    </div>
                </div>

        </div>
</div>


<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
<script>
  $('#example2').calendar({
  type: 'date'
});
$('#date_of_post').calendar({
  type: 'date'
});
  </script>
    <!-- Wrapper End-->

    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js"></script>
   
<script>
    $("#timeInput").clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        default: 'now',
        donetext: "Select",
        twelvehour: true,  // Enables 12-hour format
        init: function() { 
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    });
</script>
  
<script>
    $("#timeInput1").clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        default: 'now',
        donetext: "Select",
        twelvehour: true,  // Enables 12-hour format
        init: function() { 
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    });
</script>

<script>
  document.getElementById('jobName').addEventListener('input', function(event) {
    // Allow letters, numbers, and spaces only (no ' or ")
    this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');
  });
</script>

    <?php
include('footer.php');
    ?>
           <?php } ?>