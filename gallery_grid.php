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

$create=1;

 ?>
 <?php 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteid'])) {
        $deleteid = mysqli_real_escape_string($db, $_POST['deleteid']);

        if ($deleteid > 0) {
            // Delete record
           $sql = "DELETE FROM gallery_image WHERE id='$deleteid'"; 
            
            if (mysqli_query($db, $sql)) {
                // Redirect after successful operation
                header("Location: gallery_list.php?success=deleted");
            } else {
                // Handle error
                echo 'Error: ' . mysqli_error($db);
            }
        }
        exit();
    }
}
 ?>
 
 
 <?php
include('left.php');
include('nav.php');
 ?>  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">
  <link href="../assets/css/own.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700&display=swap">
    <link rel="stylesheet" href="../styles.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.css">

  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="path/to/your/styles.css">

      
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">

 <style>

.container {
            display: flex;
            justify-content: center;
            align-items: center;
           
        }
        .alert-success {
            color: #155724;
            background-color:rgba(0,255,0,0.3);
            border-color: #c3e6cb;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            transition: opacity 1s ease-in-out;
        }
        .alert-info {
            color: #0c5460;
            background-color:rgba(0,0,255,0.3);
            border-color: #bee5eb;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            transition: opacity 1s ease-in-out;
        }
        .alert-warning {
            color: #856404;
            background-color:rgba(255,0,0,0.3);
            border-color: #ffeeba;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            transition: opacity 1s ease-in-out;
        }
        .alert-hidden {
            opacity: 0;
            display: none;
        }


         /* Google Fonts - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');


.slide-container{
max-width: 1120px;
width: 100%;
padding: 40px 0;
}
.slide-content{
margin: 0 40px;
overflow: hidden;
border-radius: 25px;
}
.card{
border-radius: 25px;
background-color: #FFF;
}
.image-content,
.card-content{
display: flex;
flex-direction: column;
align-items: center;
padding: 10px 14px;
}
.image-content{
position: relative;
row-gap: 5px;
padding: 25px 0;
}
.overlay{
position: absolute;
left: 0;
top: 0;
height: 100%;
width: 100%;
background-color: #ffffff;
border-radius: 25px 25px 0 25px;
}
.overlay::before,
.overlay::after{
content: '';
position: absolute;
right: 0;
bottom: -40px;
height: 40px;
width: 40px;
background-color: #ffffff;
}
.overlay::after{
border-radius: 0 25px 0 0;
background-color: #FFF;
}
.card-image{
position: relative;
height: 150px;
width: 325px;

}
.card-image .card-img{
height: 100%;
width: 100%;
object-fit: cover;
}
.name{
font-size: 18px;
font-weight: 500;
color: #333;
}
.description{
font-size: 14px;
color: #707070;
text-align: center;
}
.button{
border: none;
font-size: 16px;
color: #FFF;
padding: 8px 16px;
background-color: #4070F4;
border-radius: 6px;
margin: 14px;
cursor: pointer;
transition: all 0.3s ease;
}
.button:hover{
background: #265DF2;
}

.swiper-navBtn{
color: #a487cf;
transition: color 0.3s ease;
}
.swiper-navBtn:hover{
color: #a487cf;
}
.swiper-navBtn::before,
.swiper-navBtn::after{
font-size: 38px;
}
.swiper-button-next{
right: 0;
}
.swiper-button-prev{
left: 0;
}
.swiper-pagination-bullet{
background-color: #6E93f7;
opacity: 1;
}
.swiper-pagination-bullet-active{
background-color: #4070F4;
}

@media screen and (max-width: 768px) {
.slide-content{
margin: 0 10px;
}
.swiper-navBtn{
display: none;
}
}

.title123 {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(to right, #a487cf, #100294);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* .logo-bar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #0B0C10;
            padding: 20px 0;
            
            border-radius: 30px;
            width: 100%;
            max-width: 1200px;
        } */

        .logo-bar {
    display: flex;
    justify-content: space-around;
    align-items: center;
    background: linear-gradient(to right, #92739e, #730cd3); /* Corrected the gradient syntax */
    padding: 20px 0;
    border-radius: 30px;
    width: 100%;
    max-width: 1200px;
}

    .logo-bar img {
        height: 50px;
        margin: 0 20px;
        filter: brightness(0) invert(1);
    }

        .marketing-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 900;
    font-size: 5rem;
    color: #000;
}

.rating-container {
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rating-text {
        color: #666;
        font-size: 18px;
    }

    .stars {
        display: flex;
        gap: 4px;
    }

    .stars svg {
        width: 20px;
        height: 20px;
        fill: #ffc107; /* Gold color */
    }

    .review-score {
        font-weight: 500;
        font-size: 14px;
        color: #000;
    }

    .total-score {
        font-size: 14px;
        color: #999;
    } 
    p {
    color: #666;
    margin: 5px 0 30px 0;
    font-size: 15px;
    line-height: 1.3;
    font-weight: 400;
}



</style>

       
      <div class="content-page">
<div class="container-fluid">
        <div class="row">
        <div class="container">
    <?php
    // Display success message based on query parameter
    if (isset($_GET['success'])) {
        $message = '';
        $alertClass = '';

        switch ($_GET['success']) {
            case 'added':
                $message = 'Record added successfully!';
                $alertClass = 'alert-success';
                break;
            case 'updated':
                $message = 'Record updated successfully!';
                $alertClass = 'alert-info';
                break;
            case 'deleted':
                $message = 'Record deleted successfully!';
                $alertClass = 'alert-warning';
                break;
        }

        if ($message) {
            echo '<div id="alert-message" class="' . htmlspecialchars($alertClass) . '">' . htmlspecialchars($message) . '</div>';
        }
    }
    ?>
</div>
            
            <div class="col-lg-12">
                     
                <div class="row">
                <div class="col-lg-12">
    <div class="card card-block card-stretch">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="font-weight-bold">Gallery Image Grid</h5>
                <a href="gallery_upload.php">
                    <button class="btn btn-success btn-sm">
                    <i class="fa fa-plus-square"></i>&nbsp; 
                        Add Image
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

                    <div class="col-lg-12">
                        <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <!-- <h5 class="font-weight-bold">Gallery List</h5> -->
                                    <a href="gallery_list.php">
                                        <button class="btn btn-secondary btn-sm">
                                                                                    Back
                                        </button>
                                    </a>
                                </div>
                                
                                <div class="table-responsive">
                                    <div class="" style="margin: 0px 18px;">
                                    <?php
            $category1 = mysqli_query($db, "SELECT *FROM  image_category WHERE status ='Active'");
            while ($cat2 = mysqli_fetch_array($category1)) {
            ?>                  <a href="gallery_grid_type.php?category=<?php echo htmlspecialchars($cat2['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="button" class="btn btn-outline-dark"><?php echo htmlspecialchars($cat2['category'], ENT_QUOTES, 'UTF-8'); ?></button>  </a>

                                    <?php } ?>
                                    </div>


                                        <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

<!-- Isotope and Lightbox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.1.0/css/glightbox.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
                                    <section id="portfolio" class="portfolio section" style="margin-top: 50px;">



<div class="container">



    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <?php
            $category1 = mysqli_query($db, "SELECT *FROM  image_category WHERE status ='Active'");
            while ($cat2 = mysqli_fetch_array($category1)) {
            ?>
                <li data-filter=".filter-<?php echo htmlspecialchars($cat2['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($cat2['category'], ENT_QUOTES, 'UTF-8'); ?>
                </li>
            <?php } ?>
        </ul><!-- End Portfolio Filters -->

        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            <?php
            $category2 = mysqli_query($db, "SELECT gi.*, ic.id AS category_id FROM gallery_image AS gi LEFT JOIN image_category AS ic ON gi.category = ic.category WHERE gi.status = 'Active'ORDER BY gi.id DESC;");
            while ($cat1 = mysqli_fetch_array($category2)) {
            ?>
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-<?php echo htmlspecialchars($cat1['category_id'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php if (!empty($cat1['image_file'])) {
    $fileType = strtolower(pathinfo($cat1['image_file'], PATHINFO_EXTENSION));
    $allowedImageTypes = array("jpg", "jpeg", "png", "gif", "webp");
    $allowedVideoTypes = array("mp4", "avi", "mov", "wmv", "mkv");

    // Check if the file is an image
    if (in_array($fileType, $allowedImageTypes)) { ?>
        <a href="<?php echo htmlspecialchars($cat1['image_file'], ENT_QUOTES, 'UTF-8'); ?>" title="<?php echo htmlspecialchars($cat1['name'], ENT_QUOTES, 'UTF-8'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
            <img src="<?php echo htmlspecialchars($cat1['image_file'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($cat1['name'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
        </a>
    <?php 
    // Check if the file is a video
    } elseif (in_array($fileType, $allowedVideoTypes)) { ?>
        <a href="<?php echo htmlspecialchars($cat1['image_file'], ENT_QUOTES, 'UTF-8'); ?>" title="<?php echo htmlspecialchars($cat1['name'], ENT_QUOTES, 'UTF-8'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
            <video autoplay muted loop class="img-fluid">
                <source src="<?php echo htmlspecialchars($cat1['image_file'], ENT_QUOTES, 'UTF-8'); ?>" type="video/<?php echo htmlspecialchars($fileType, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                Your browser does not support the video tag.
            </video>
        </a>
    <?php }
} ?>

<div style="text-align: left;">
                    <div class="portfolio-info">
                        <h4><?php echo htmlspecialchars($cat1['name'], ENT_QUOTES, 'UTF-8'); ?></h4>
                        <p><?php echo htmlspecialchars($cat1['category'], ENT_QUOTES, 'UTF-8'); ?></p>

                        <a href="gallery_upload.php?id=<?php echo $cat1['id']; ?>">
                        <button class="badge badge-primary" style="border:none;" data-toggle="tooltip" style="align-items: left;" data-placement="top" title="Edit">
                            Edit
                        </button>
                    </a>
                    &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <form action="gallery_grid.php" method="POST" style="display: inline;">
    <input type="hidden" name="deleteid" value="<?php echo isset($cat1['id']) ? htmlspecialchars($cat1['id']) : ''; ?>">
    <button type="submit" class="badge badge-danger" style="border:none;" data-toggle="tooltip" data-placement="top" title="Delete">
        Delete
    </button></div>
                    </div>
                </div><!-- End Portfolio Item -->
            <?php } ?>
        </div><!-- End Portfolio Container -->

    </div>

</div>

</section><!-- /Portfolio Section -->

<!-- Bootstrap, jQuery, AOS, Isotope, Lightbox JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.1.0/js/glightbox.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize AOS
        AOS.init({
            duration: 1000,
        });

        // Initialize Isotope
        var elem = document.querySelector('.isotope-container');
        var iso = new Isotope(elem, {
            itemSelector: '.isotope-item',
            layoutMode: 'masonry'
        });

        // Portfolio filter functionality
        var filtersElem = document.querySelector('.portfolio-filters');
        filtersElem.addEventListener('click', function (event) {
            if (event.target.tagName === 'LI') {
                var filterValue = event.target.getAttribute('data-filter');
                iso.arrange({ filter: filterValue });

                // Add active class
                document.querySelector('.filter-active').classList.remove('filter-active');
                event.target.classList.add('filter-active');
            }
        });

        // Initialize Lightbox
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    });
</script>


 <!-- Vendor JS Files -->
 <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>


  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>
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




    <!-- Wrapper End-->
    <script>




document.addEventListener('DOMContentLoaded', function() {
    var alert = document.getElementById('alert-message');
    if (alert) {
        setTimeout(function() {
            alert.classList.add('alert-hidden');
        }, 3000); // Hide after 5 seconds
    }
});









    function openDatePopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;

        var popup = window.open("edit_completion.php?id=" + jobId, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

        if (popup) {
            popup.focus();
        } else {
            alert('Please allow pop-ups to enter the date.');
        }
    }

    function openmemberpopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;
        var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

    var popup = window.open("edit_members.php?id=" + jobId + "&logname=" + logName, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

        if (popup) {
            popup.focus();
        } else {
            alert('Please allow pop-ups to enter the date.');
        }
    }

    function openreferencepopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;
        var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

    var popup = window.open("edit_reference.php?id=" + jobId, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

        if (popup) {
            popup.focus();
        } else {
            alert('Please allow pop-ups to enter the date.');
        }
    }

    function openmemberpopup(jobId) {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var popupWidth = 800;
        var popupHeight = 500;

        var leftPosition = (screenWidth - popupWidth) / 2;
        var topPosition = (screenHeight - popupHeight) / 2;
        var logName = "<?php echo $_SESSION['uname']; ?>"; // PHP session variable for logged-in username

    var popup = window.open("member_created.php?id=" + jobId + "&logname=" + logName, "DateInputWindow", "width=" + popupWidth + ",height=" + popupHeight + ",left=" + leftPosition + ",top=" + topPosition);

        if (popup) {
            popup.focus();
        } else {
            alert('Please allow pop-ups to enter the date.');
        }
    }
</script>

 

    <?php
include('footer.php');
    ?>
    <?php } ?>