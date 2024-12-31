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

.main-wrapper {
    max-width: 1170px;
    margin: 0 auto;
    text-align: center;
  }
  .upload-main-wrapper {
    width: 220px;
    /* margin: 0 auto; */
  }
  #file-upload-name {
    margin: 4px 0 0 0;
    font-size: 12px;
    display: none;
  }
  .upload-wrapper {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    /* margin: 40px auto 0; */
    position: relative;
    cursor: pointer;
    background-color: #e92626;
    padding: 8px 10px;
    border-radius: 10px;
    /* box-shadow: 1px 4px 13px 5px rgb(135 126 126 / 93); */
    overflow: hidden;
    transition: 0.2s linear all;
    color: #fff;
  }
  .upload-wrapper input[type="file"] {
    width: 100%;
    position: absolute;
    left: 0;
    right: 0;
    opacity: 0;
    top: 0;
    bottom: 0;
    cursor: pointer;
    z-index: 1;
  }
  .upload-wrapper > svg {
    width: 50px;
    height: auto;
    cursor: pointer;
  }
  .upload-wrapper.success > svg {
    transform: translateX(-200px);
  }
  .upload-wrapper.uploaded {
    transition: 0.2s linear all;
    width: 60px;
    border-radius: 50%;
    height: 60px;
    text-align: center;
  }
  .upload-wrapper .file-upload-text {
    position: absolute;
    left: 80px;
    opacity: 1;
    visibility: visible;
    transition: 0.2s linear all;
  }
  .upload-wrapper.uploaded .file-upload-text {
    text-indent: -999px;
    margin: 0;
  }
  .file-success-text {
    opacity: 0;
    transition: 0.2s linear all;
    visibility: hidden;
    transform: translateX(200px);
    position: absolute;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .file-success-text svg {
    width: 25px;
    height: auto;
  }
  .file-success-text span {
    margin-left: 15px;
  }
  .upload-wrapper.success .file-success-text {
    opacity: 1;
    visibility: visible;
    transform: none;
  }
  .upload-wrapper.success.uploaded .file-success-text {
    opacity: 1;
    visibility: visible;
    transform: none;
  }
  .upload-wrapper.success.uploaded .file-success-text span {
    display: none;
  }
  .upload-wrapper .file-success-text circle {
    stroke-dasharray: 380;
    stroke-dashoffset: 380;
    transition: 1s linear all;
    transition-delay: 1.4s;
  }
  .upload-wrapper.success .file-success-text circle {
    stroke-dashoffset: 0;
  }
  .upload-wrapper .file-success-text polyline {
    stroke-dasharray: 380;
    stroke-dashoffset: 380;
    transition: 1s linear all;
    transition-delay: 2s;
  }
  .upload-wrapper.success .file-success-text polyline {
    stroke-dashoffset: 0;
  }
  .upload-wrapper.success .file-upload-text {
    -webkit-animation-name: bounceOutLeft;
    animation-name: bounceOutLeft;
    -webkit-animation-duration: 0.2s;
    animation-duration: 0.2s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
  }
  @-webkit-keyframes bounceOutLeft {
    20% {
      opacity: 1;
      -webkit-transform: translate3d(20px, 0, 0);
      transform: translate3d(20px, 0, 0);
   }
    to {
      opacity: 0;
      -webkit-transform: translate3d(-2000px, 0, 0);
      transform: translate3d(-2000px, 0, 0);
   }
  }
  @keyframes bounceOutLeft {
    20% {
      opacity: 1;
      -webkit-transform: translate3d(20px, 0, 0);
      transform: translate3d(20px, 0, 0);
   }
    to {
      opacity: 0;
      -webkit-transform: translate3d(-2000px, 0, 0);
      transform: translate3d(-2000px, 0, 0);
   }
  }
 .display_table {
    overflow: auto;
}

.p_upload_file{
  padding: 10px 0px;
  color: red;
}

    </style>
</head>
<body>
<form class="survey-form" method="post" action="process_reference.php" enctype="multipart/form-data">
        <?php $id = $_GET['id']; ?>
        <div class="form-group">
        <label for="date">Edit reference Update : </label>
        <div class="main-wrapper">
                                            <div class="upload-main-wrapper">
                                                    <div class="upload-wrapper">
                                                            <input type="file" id="upload-file" name="pdfFile">
                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" viewBox="224.3881704980842 176.8527621722847 221.13266283524905 178.8472378277154" width="221.13" height="178.85"><defs><path d="M357.38 176.85C386.18 176.85 409.53 204.24 409.53 238.02C409.53 239.29 409.5 240.56 409.42 241.81C430.23 246.95 445.52 264.16 445.52 284.59C445.52 284.59 445.52 284.59 445.52 284.59C445.52 309.08 423.56 328.94 396.47 328.94C384.17 328.94 285.74 328.94 273.44 328.94C246.35 328.94 224.39 309.08 224.39 284.59C224.39 284.59 224.39 284.59 224.39 284.59C224.39 263.24 241.08 245.41 263.31 241.2C265.3 218.05 281.96 199.98 302.22 199.98C306.67 199.98 310.94 200.85 314.93 202.46C324.4 186.96 339.88 176.85 357.38 176.85Z" id="b1aO7LLtdW"></path><path d="M306.46 297.6L339.79 297.6L373.13 297.6L339.79 255.94L306.46 297.6Z" id="c4SXvvMdYD"></path><path d="M350.79 293.05L328.79 293.05L328.79 355.7L350.79 355.7L350.79 293.05Z" id="b11si2zUk"></path></defs><g><g><g><use xlink:href="#b1aO7LLtdW" opacity="1" fill="#ffffff" fill-opacity="1"></use></g><g><g><use xlink:href="#c4SXvvMdYD" opacity="1" fill="#363535" fill-opacity="1"></use></g><g><use xlink:href="#b11si2zUk" opacity="1" fill="#363535" fill-opacity="1"></use></g></g></g></g></svg>
                                                            <span class="file-upload-text">Upload File</span>
                                                            <div class="file-success-text">
                                                            <svg version="1.1" id="check" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" xml:space="preserve">
                                                    <circle style="fill:rgba(0,0,0,0);stroke:#ffffff;stroke-width:10;stroke-miterlimit:10;" cx="49.799" cy="49.746" r="44.757"></circle>
                                                    <polyline style="fill:rgba(0,0,0,0);stroke:#ffffff;stroke-width:10;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" points="
                                                        27.114,51 41.402,65.288 72.485,34.205 "></polyline>
                                                    </svg> <span>Successfully</span></div>
                                                        </div>
                                                        <p id="file-upload-name"></p>
                                            </div>
                                  </div>
        

            <input type="hidden" id="jobId" name="jobId" value="<?php echo $_GET['id']; ?>">
        </div>
        <button type="submit">Submit</button>
    </form>

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
      $("form").on("change", ".file-upload-field", function(){ 
    $(this).parent(".file-upload-wrapper").attr("data-text",         $(this).val().replace(/.*(\/|\\)/, '') );
});
    </script>

    <script>
     $(document).ready(function(){
             $('#upload-file').change(function() {
                var filename = $(this).val();
                $('#file-upload-name').html(filename);
                if(filename!=""){
                    setTimeout(function(){
                        $('.upload-wrapper').addClass("uploaded");
                    }, 600);
                    setTimeout(function(){
                        $('.upload-wrapper').removeClass("uploaded");
                        $('.upload-wrapper').addClass("success");
                    }, 1600);
                }
            });
        });
    </script>
</body>
</html>