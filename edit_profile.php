<?php
include('top.php');
include('left.php');
include('nav.php');




?>

<div class="content-page">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body p-0">
                     <div class="iq-edit-list usr-edit">
                        <ul class="iq-edit-profile d-flex nav nav-pills">
                           <li class="col-md-4 p-0">
                              <a class="nav-link active" data-toggle="pill" href="#personal-information">
                              Personal Information
                              </a>
                           </li>
                           <li class="col-md-4 p-0">
                              <a class="nav-link" data-toggle="pill" href="#chang-pwd">
                              Change Password
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="iq-edit-list-data">
                  <div class="tab-content">
                     <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                        <div class="card">
                           <div class="card-header d-flex justify-content-between">
                              <div class="header-title">
                                 <h4 class="card-title">Personal Information</h4>
                              </div>
                           </div>
                           <div class="card-body">
                           <form method="POST" enctype="multipart/form-data" action="process_form.php" onsubmit="return validateMobileNumber();">
                           <?php
        
                              $sqlUpdated = "SELECT * FROM members WHERE id = '$id'";
                              // echo $sqlUpdated;
                              // exit;
                              $resultUpdated = mysqli_query($db, $sqlUpdated);

                              while ($member_profile = mysqli_fetch_assoc($resultUpdated)) {
                                    $m_fname = $member_profile['fname'];
                                    $m_lname = $member_profile['lname'];
                           {
    
                                  ?>
                                 <div class=" row align-items-center">
                                    <div class="col-md-5">
                                       <div class="profile-img-edit">
                                          <div class="crm-profile-img-edit">
                                             <!-- <img class="crm-profile-pic rounded-circle avatar-100" src="assets/images/user/1.jpg" alt="profile-pic"> -->
                                             <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file'name= "imageUpload" id="imageUpload" accept=".png, .jpg, .jpeg .webp" />
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                   <?php if ($member_profile['profile_picture'] != null) { ?>
                                                      <!-- Display the image when profile_picture exists -->
                                                      <div id="imagePreview" style="background-image: url('<?php echo $member_profile['profile_picture']; ?>');"></div>
                                                   <?php } else { ?>
                                                      <!-- Display a default image when profile_picture is null or empty -->
                                                      <div id="imagePreview" style="background-image: url('members_img/noimg.jpg');"></div>
                                                   <?php } ?>
                                                </div>

                                            </div>
                                         
                                          </div>                                          
                                       </div>
                                    </div>
                                 </div>
                                 <div class=" row align-items-center">
                                 <input type="hidden" class="form-control" id="member_id" name="member_id" value="<?php echo $id; ?>">
                                    <div class="form-group col-sm-6">
                                       <label for="fname">First Name:</label>
                                       <input type="text" class="form-control" id="fname" name="fname" value="<?php if ($m_fname!="null") {echo $m_fname;}  ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="lname">Last Name:</label>
                                       <input type="text" class="form-control" id="lname" name="lname" value="<?php if ($m_lname!="null") {echo $m_lname;}  ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="uname">Designation:</label>
                                       <input type="text" class="form-control" id="designation" name="designation"   value="<?php if ($member_profile['designation']!="null") {echo $member_profile['designation'];}  ?>">
                                    </div>
                                
                                    <div class="form-group col-sm-6">
                                       <label for="uname">User Name:</label>
                                       <input type="text" class="form-control" id="uname" name="uname" readonly  value="<?php if ($member_profile['username']!="null") {echo $member_profile['username'];}  ?>">
                                    </div>
                                    
                                    <div class="form-group col-sm-6">
                                       <label for="doj">Date of Joining</label>
                                       <input type="date" class="form-control" id="doj" name="doj"   value="<?php if ($member_profile['doj']!="null") {echo $member_profile['doj'];}  ?>">
                                    </div>

                                    <div class="form-group col-sm-6">
                                       <label for="job_location">Job Location</label>
                                       <input type="text" class="form-control" id="job_location" name="job_location"   value="<?php if ($member_profile['job_location']!="null") {echo $member_profile['job_location'];}  ?>">
                                    </div>

                                    <div class="form-group col-sm-6">
                                       <label for="uname">Email:</label>
                                       <input type="email" class="form-control" id="email" name="email" value="<?php if ($member_profile['email']!="null") {echo $member_profile['email'];}  ?>">
                                    </div>

                                    <div class="form-group col-sm-6">
                                       <label for="uname">Contact No:</label>
                                       <input type="text" class="form-control" id="mobile" name="mobile" value="<?php if ($member_profile['mobile']!="null") {echo $member_profile['mobile'];}  ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="cname">City:</label>
                                       <input type="text" class="form-control" id="cname" name="cname" value="<?php if ($member_profile['username']!="null") {echo $member_profile['city'];}  ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label class="d-block">Gender:</label>
                                       <div class="field-holder">
                                       <label for="schedule_type">
                                             <input type="radio" name="schedule" id="male" value="Male" <?php echo ($member_profile['gender'] == 'Male') ? 'checked' : ''; ?>>Male
                                       </label>
                                       <label for="schedule_type">
                                             <input type="radio" name="schedule" id="female" value="Female" <?php echo ($member_profile['gender'] == 'Female') ? 'checked' : ''; ?>>Female
                                       </label>
                                       <label for="schedule_type">
                                             <input type="radio" name="schedule" id="others" value="Others" <?php echo ($member_profile['gender'] == 'Others') ? 'checked' : ''; ?>>Others
                                       </label>
											
											</div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="dob">Date Of Birth:</label>
                                       <input type="date"  class="form-control" id="dob" name="dob" value="<?php if ($member_profile['dob']!="null") {echo $member_profile['dob'];}  ?>">
                                    </div>
                                    <!-- <div class="form-group col-sm-6">
                                       <label>Marital Status:</label>
                                       <select class="form-control" id="exampleFormControlSelect1">
                                          <option selected="" value="Single">Single</option>
                                          <option value="Married" >Married</option>
                                          <option>Widowed</option>
                                          <option>Divorced</option>
                                          <option>Separated </option>
                                       </select>
                                    </div> -->
                                
                                    <div class="form-group col-sm-12">
                                       <label>Bank Account Details:</label>
                                       <textarea class="form-control" name="bank_account_details" rows="3" style="line-height: 22px;">
                                          <?php if ($member_profile['bank_account_details'] != null) {
                                             echo $member_profile['bank_account_details'];
                                          } ?>
                                       </textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                       <label>Address:</label>
                                       <textarea class="form-control" name="address" rows="3" style="line-height: 22px;">
                                       <?php if ($member_profile['address'] != null) {
                                             echo $member_profile['address'];
                                          } ?>
                                       </textarea>
                                    </div>
                                 </div>
                                 <!-- <button type="reset" class="btn btn-outline-primary mr-2">Cancel</button> -->
                                 <button type="submit" class="btn btn-primary">Submit</button>
                                 <?php }} ?>
                              </form>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                        <div class="card">
                           <div class="card-header d-flex justify-content-between">
                              <div class="header-title">
                                 <h4 class="card-title">Change Password</h4>
                              </div>
                           </div>
                           <div class="card-body">
                              <form action="changepassword.php" method="POST"  autocomplete="off">
                              <input type="hidden" class="form-control" id="member_id" name="member_id" value="<?php echo $id; ?>">
                                 <div class="form-group">
                                    <label for="cpass">Current Password:</label>
                                    <!-- <a href="javascripe:void();" class="float-right">Forgot Password</a> -->
                                    <input type="Password" class="form-control" id="old_pass" name="old_pass" value="" autocomplete="off">
                                 </div>
                                 <div class="form-group">
                                    <label for="npass">New Password:</label>
                                    <input type="Password" class="form-control" name="new_pass" id="new_pass" value="">
                                 </div>
                                 <div class="form-group">
                                    <label for="vpass">Verify Password:</label>
                                    <input type="Password" class="form-control" name="con_pass" id="con_pass" value="">
                                 </div>
                                 <!-- <button type="reset" class="btn btn-outline-primary mr-2">Cancel</button> -->
                                 <button type="submit" class="btn btn-primary" >Submit</button>
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
     <script>
      function validateMobileNumber() {
    var mobileNumber = document.getElementById('mobile').value;
    var regex = /^\d{10}$/;

    if (regex.test(mobileNumber)) {
        // Mobile number is valid
        return true;
    } else {
        // Invalid mobile number format
        alert('Please enter a valid 10-digit mobile number.');
        return false;
    }
}

   </script>
      <?php
include('footer.php');
    ?>
