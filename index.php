<?php 
error_reporting(0);

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!doctype html>
<html lang="en">
  

<head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Avatar Global Services</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/logo/icon.png" />
      
      <link rel="stylesheet" href="assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="assets/css/backende209.css?v=1.0.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

      <style>
        #showPass {
  display:inline-block;
  margin-left:-40px;
}

.dark #showPass {
  display:inline-block;
  margin-left:-40px;
  color:blue;
}
.form-control {
    display: inline-block;
    width: 95%;
    height: calc(1.5em + 1.25rem + 2px);
    padding: .625rem 1.25rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

        </style>
  <body class=" ">
    
    
      <div class="wrapper">
    <section class="login-content">
         <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
               <div class="col-md-5">
                  <div class="card p-3">
                     <div class="card-body">
                        <div class="auth-logo">
                           <img src="assets/images/logo/icon.png" class="img-fluid  rounded-normal  darkmode-logo" alt="logo">
                           <img src="assets/images/logo/icon.png" class="img-fluid rounded-normal light-logo" alt="logo">
                        </div>
                        <h3 class="mb-3 font-weight-bold text-center">Log In</h3>
                        <?php if($_GET['a']!="") {?><div class="alert alert-error" style="color:#6b0e0e;font-size:18px;"> <?php echo $_GET['a'];?>  <!--<strong>Error!</strong> Please enter an username and a password.-->
        </div><?php } ?>
                        
                     
              <form  action="login_check.php" method="POST">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label class="text-secondary">Username</label>
                                    <input class="form-control" type="text" id="uname" name="uname" placeholder="USER-NAME" required="">
                                 </div>
                              </div>
                              <div class="col-lg-12 mt-2">
                                 <div class="form-group formbox">
                                     <div class="d-flex justify-content-between align-items-center">
                                         <label class="text-secondary">Password</label>
                                         <!-- <label><a href="auth-recover-pwd.html">Forgot Password?</a></label> -->
                                     </div>
                                     <input type="password" class="form-control" name="pass" placeholder="Enter Password" id="myPass">
                                    <!-- <input class="form-control" type="password" name="pass" class="form-input" placeholder="Enter Password"  id="myPass"> -->
                                    <span id="showPass">
    <i class="fa fa-eye-slash" aria-hidden="true"></i>
    <i class="fa fa-eye" aria-hidden="true" style="display:none;"></i>
  </span>
                                 </div>
                              </div>
                           </div>
                           <button type="submit" class="btn btn-primary btn-block mt-2">Log In</button>
                           <!-- <div class="col-lg-12 mt-3">
                                <p class="mb-0 text-center">Don't have an account? <a href="auth-sign-up.html">Sign Up</a></p>
                           </div> -->
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      </div>
    
    <!-- Backend Bundle JavaScript -->
    <script src="assets/js/backend-bundle.min.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="assets/js/customizer.js"></script>
    
    <script src="assets/js/sidebar.js"></script>
    
    <!-- Flextree Javascript-->
    <script src="assets/js/flex-tree.min.js"></script>
    <script src="assets/js/tree.js"></script>
    
    <!-- Table Treeview JavaScript -->
    <script src="assets/js/table-treeview.js"></script>
    
    <!-- SweetAlert JavaScript -->
    <script src="assets/js/sweetalert.js"></script>
    
    <!-- Vectoe Map JavaScript -->
    <script src="assets/js/vector-map-custom.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script src="assets/js/chart-custom.js"></script>
    <script src="assets/js/charts/01.js"></script>
    <script src="assets/js/charts/02.js"></script>
    
    <!-- slider JavaScript -->
    <script src="assets/js/slider.js"></script>
    
    <!-- Emoji picker -->
    <script src="assets/vendor/emoji-picker-element/index.js" type="module"></script>
    
    
    <!-- app JavaScript -->
    <script src="assets/js/app.js"></script>  </body>
    <script>
            // main section
            document.addEventListener('alpine:init', () => {
                Alpine.data('scrollToTop', () => ({
                    showTopButton: false,
                    init() {
                        window.onscroll = () => {
                            this.scrollFunction();
                        };
                    },

                    scrollFunction() {
                        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                            this.showTopButton = true;
                        } else {
                            this.showTopButton = false;
                        }
                    },

                    goToTop() {
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                    },
                }));
            });
        </script>
    <script>
history.pushState(null, null, window.location.href);
window.onpopstate = function () {
    history.go(1);
};
history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
  history.pushState(null, null, document.URL);
});

     </script> 
     <script>
        $(document).ready(function() {
  $("#showPass").click(function() {
    if ($("#myPass").attr("type") == "password") {
      $("#myPass").attr("type", "text");
    } else {
      $("#myPass").attr("type", "password");
    }
  });
  $("#showPass").click(function() {
    $("#showPass i").toggle();
  });
});

        </script>
</html>