 
 <?php
 
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
// session_start();
   
    ?>
 
 <div class="iq-sidebar  sidebar-default  ">
          <div class="iq-sidebar-logo d-flex align-items-end justify-content-between">
               <a href="index.php" class="header-logo">
                  <img src="assets/images/logo/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                 
                 
              </a>
              <div class="side-menu-bt-sidebar-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="text-light wrapper-menu" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                  </div>
          </div>
          <div class="data-scrollbar" data-scroll="1">
              <nav class="iq-sidebar-menu">
                  <ul id="iq-sidebar-toggle" class="side-menu">

                <?php if($name_member_id =="1") {?>
                    <li class=" <?php if($home=='1'){?>active <?php }?> sidebar-layout">
                          <a href="dashboard.php" class="svg-icon">
                              <i class="">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                  </svg>
                              </i>
                              <span class="ml-2">Dashboard</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                      <!--<li class=" <?php if($my_works=='1'){?>active <?php }?> sidebar-layout">-->
                      <!--    <a href="my_works.php" class="svg-icon">-->
                      <!--    <i class="fa fa-tasks"></i>-->
                      <!--        <span class="ml-2">My Works</span>-->
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                      <!--    </a>-->
                      <!--</li>-->

                      <li class=" <?php if($job_submit=='1'){?>active <?php }?>  sidebar-layout">
                          <a href="job_submission.php" class="svg-icon">
                          <i class="fa fa-paper-plane" aria-hidden="true"></i>
                              <span class="ml-2">Job Submission</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                 
                <?php } else {?>   
                    <li class=" <?php if($job_submit=='1'){?>active <?php }?>  sidebar-layout">
                          <a href="job_submission.php" class="svg-icon">
                          <i class="fa fa-paper-plane" aria-hidden="true"></i>
                              <span class="ml-2">Job Submission</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                     
                 <?php }?> 
                      

                      <li class=" <?php if($job_create=='1'){?>active <?php }?>  sidebar-layout">
                          <a href="job_creation.php" class="svg-icon">
                             <i class="fa fa-plus-square"></i>
                              <span class="ml-2">Job Creation</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                      <?php if($log_name =="Mahendran") {?>
                    <li class=" <?php if($staff=='1'){?>active <?php }?> sidebar-layout">
                          <a href="staff_details.php" class="svg-icon">
                          <i class="fa fa-users" aria-hidden="true"></i>
                              <span class="ml-2">Staff Details</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                      <li class=" <?php if($complete=='1'){?>active <?php }?> sidebar-layout">
                          <a href="complete_job.php" class="svg-icon">
                          <i class="fa fa-check" aria-hidden="true"></i>
                              <span class="ml-2">Completed Jobs</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                      
                      

                
                 
                 <?php } ?>
                    <?php if($log_name !=="Mahendran") {?>
                        <li class=" <?php if($create=='1'){?>active <?php }?> sidebar-layout">
                          <a href="created_me.php" class="svg-icon">
                          <i class="fa fa-history" aria-hidden="true"></i>
                              <span class="ml-2">Created Jobs</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                      <li class=" <?php if($closed=='1'){?>active <?php }?> sidebar-layout">
                          <a href="user_complete.php" class="svg-icon">
                          <i class="fa fa-check-circle"></i>
                              <span class="ml-2">Closed Jobs</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                      <li class=" <?php if($present_job=='1'){?>active <?php }?> sidebar-layout">
                          <a href="present_job.php" class="svg-icon">
                          <i class="fa fa-check-circle"></i>
                              <span class="ml-2">Present Jobs</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                    <li class=" <?php if($export_pdf=='1'){?>active <?php }?> sidebar-layout">
                          <a href="export_as_pdf.php" class="svg-icon">
                          <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                              <span class="ml-2">Export as PDF</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                    <?php }?>

                    <?php if($log_name =="Mahendran") {?>
                    <li class=" <?php if($iteration=='1'){?>active <?php }?> sidebar-layout">
                          <a href="iteration.php" class="svg-icon">
                          <i class="fa fa-check-circle"></i>
                              <span class="ml-2">Iteration Tasks</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                      <?php }?>

                    <?php if($name_member_id =="1" || $name_member_id =="5") {?>
                        <li class=" <?php if($add_client=='1'){?>active <?php }?> sidebar-layout">
                          <a href="add_clients.php" class="svg-icon">
                          <i class="fa fa-user-circle-o"></i>
                              <span class="ml-2">Add Clients</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                      <li class=" <?php if($career=='1'){?>active <?php }?> sidebar-layout">
                          <a href="career.php" class="svg-icon">
                          <i class="fa fa-user" aria-hidden="true"></i>
                              <span class="ml-2">Careers</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                      <li class=" <?php if($career_list=='1'){?>active <?php }?> sidebar-layout">
                          <a href="career_list.php" class="svg-icon">
                          <i class="fa fa-id-badge"></i>
                              <span class="ml-2">Careers Applications</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                      <li class=" <?php if($meetings=='1'){?>active <?php }?> sidebar-layout">
                          <a href="meetings.php" class="svg-icon">
                          <i class="fa fa-desktop"></i>
                              <span class="ml-2">Weekly Meetings</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>

                      <li class=" <?php if($export_pdf=='1'){?>active <?php }?> sidebar-layout">
                          <a href="export_as_pdf.php" class="svg-icon">
                          <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                              <span class="ml-2">Export as PDF</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                      <li class=" <?php if($present_job=='1'){?>active <?php }?> sidebar-layout">
                          <a href="present_job.php" class="svg-icon">
                          <i class="fa fa-check-circle"></i>
                              <span class="ml-2">Present Jobs</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                      <li class=" <?php if($emergency_reminder=='1'){?>active <?php }?> sidebar-layout">
                          <a href="emergency_reminder.php" class="svg-icon">
                          <i class="fa fa-external-link"></i>
                              <span class="ml-2">Emergency reminders</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                
                      
                    <?php }?>
                    <?php if($name_member_id =="27") {?>
                          <li class=" <?php if($gallery_list =='1'){?>active <?php }?>  sidebar-layout">
                          <a href="gallery_list.php" class="svg-icon">
                             <i class="fa fa-plus-square"></i>
                              <span class="ml-2">Gallery Upload</span>
                              <!-- <p class="mb-0 w-10 badge badge-pill badge-primary">6</p> -->
                          </a>
                      </li>
                        <?php }?>
                     
                  </ul>
              </nav>
              <div class="pt-5 pb-5"></div>
          </div>
        </diV>