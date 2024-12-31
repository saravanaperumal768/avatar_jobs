<?php
session_start();
include("connection.php");

$log_name = $_SESSION["uname"];



$destination = isset($_POST['destination']) ? mysqli_real_escape_string($db, $_POST['destination']) : '';
$skills = isset($_POST['skills']) ? mysqli_real_escape_string($db, $_POST['skills']) : '';
$experience = isset($_POST['experience']) ? mysqli_real_escape_string($db, $_POST['experience']) : '';
$location = isset($_POST['location']) ? mysqli_real_escape_string($db, $_POST['location']) : '';
$status = isset($_POST['status']) ? mysqli_real_escape_string($db, $_POST['status']) : '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$create_at = date("Y-m-d H:i:s");


$targetDir = "career/";
$allowedFileTypes = array("jpg", "jpeg", "png", "gif", "webp", "mp4", "avi", "mov", "wmv", "mkv");

$uploadedFiles = [];
if (!empty($_FILES['pdfFiles']['name'][0])) {
    $fileCount = count($_FILES['pdfFiles']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        $originalFileName = $_FILES['pdfFiles']['name'][$i];
        $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
        $uniqueFileName = time() . '-' . $i . '.' . $fileType;
        $targetFile = $targetDir . $uniqueFileName;

        if (!in_array($fileType, $allowedFileTypes)) {
            echo "<script type='text/javascript'>alert('Sorry, only image and video files (JPG, JPEG, PNG, GIF, WEBP, MP4, AVI, MOV, WMV, MKV) are allowed.');</script>";
            error_log("Detected File Type: $fileType");
        } else {
            if (move_uploaded_file($_FILES['pdfFiles']['tmp_name'][$i], $targetFile)) {
                $uploadedFiles[] = $targetFile;
            } else {
                echo "<script type='text/javascript'>alert('Error uploading file. Please try again.');</script>";
            }
        }
    }
}


$fileLinksImploded = !empty($uploadedFiles) ? implode(',', $uploadedFiles) : '';

//echo "$fileLinksImploded";exit;

if ($fileLinksImploded) {
    if ($id > 0) {


      // Update existing record
        $sql = "UPDATE careers SET 
                	destination='$destination', 
                skills='$skills', 
                experience='$experience', 
                location='$location', 
                destination_icon='$fileLinksImploded', 
                updated_by='$log_name', 
                status='$status', 
                updated_at='$create_at' 
                WHERE id='$id'";




        // Sanitize qualifications and responsibilities
        $qualifications = isset($_POST['qualifications']) ? $_POST['qualifications'] : [];
        $qualifications_id = isset($_POST['qualifications_id']) ? $_POST['qualifications_id'] : [];
        
        $qualifications = array_map(function($qual) use ($db) {
            return mysqli_real_escape_string($db, $qual);
        }, $qualifications);
        
        $responsibilities = isset($_POST['responsibilities']) ? $_POST['responsibilities'] : [];
        $responsibilities_id = isset($_POST['responsibilities_id']) ? $_POST['responsibilities_id'] : [];
        
        $responsibilities = array_map(function($resp) use ($db) {
            return mysqli_real_escape_string($db, $resp);
        }, $responsibilities);
        
        // Insert qualifications
        if (is_array($qualifications) && !empty($qualifications)) {
            foreach ($qualifications as $index => $qualification) {
                $qualification_id = isset($qualifications_id[$index]) ? $qualifications_id[$index] : null;
        
                // Escape variables to prevent SQL injection
                $destination = mysqli_real_escape_string($db, $destination);
                $qualification = mysqli_real_escape_string($db, $qualification);
                $log_name = mysqli_real_escape_string($db, $log_name);
                $create_at = mysqli_real_escape_string($db, $create_at);
                $id = mysqli_real_escape_string($db, $id);
        
                if ($qualification_id) {
                    $query = "UPDATE qualifications SET 
                                destination='$destination', 
                                qualifications='$qualification', 
                                updated_by='$log_name',  
                                updated_at='$create_at' 
                                WHERE careers_id='$id' AND id='$qualification_id'";
        
                    if (!mysqli_query($db, $query)) {
                        echo "Error updating qualification: " . mysqli_error($db);
                    } else {
                        echo "Updated qualification: $qualification<br/>";
                    }
                } else {
                    $query = "INSERT INTO qualifications (careers_id, destination, qualifications, create_by, create_at) 
                              VALUES ('$id', '$destination', '$qualification', '$log_name', '$create_at')";
        
                    if (!mysqli_query($db, $query)) {
                        echo "Error inserting qualification: " . mysqli_error($db);
                    } else {
                        echo "Inserted qualification: $qualification<br/>";
                    }
                }
            }
        } else {
            echo 'No qualifications provided.<br/>';
        }
        
        
        if (is_array($responsibilities) && !empty($responsibilities)) {
            foreach ($responsibilities as $index => $responsibility) {
                $responsibility_id = isset($responsibilities_id[$index]) ? $responsibilities_id[$index] : null;
        
                // Escape variables to prevent SQL injection
                $destination = mysqli_real_escape_string($db, $destination);
                $responsibility = mysqli_real_escape_string($db, $responsibility);
                $log_name = mysqli_real_escape_string($db, $log_name);
                $create_at = mysqli_real_escape_string($db, $create_at);
                $id = mysqli_real_escape_string($db, $id);
        
                if ($responsibility_id) {
                    $query = "UPDATE responsibilities SET 
                                destination='$destination', 
                                responsibilities='$responsibility', 
                                updated_by='$log_name',  
                                updated_at='$create_at' 
                                WHERE careers_id='$id' AND id='$responsibility_id'";
        
                    if (!mysqli_query($db, $query)) {
                        echo "Error updating responsibility: " . mysqli_error($db);
                    } else {
                        echo "Updated responsibility: $responsibility<br/>";
                    }
                } else {
                    $query = "INSERT INTO responsibilities (careers_id, destination, responsibilities, create_by, create_at) 
                              VALUES ('$id', '$destination', '$responsibility', '$log_name', '$create_at')";
        
                    if (!mysqli_query($db, $query)) {
                        echo "Error inserting responsibility: " . mysqli_error($db);
                    } else {
                        echo "Inserted responsibility: $responsibility<br/>";
                    }
                }
            }
        } else {
            echo 'No responsibilities provided.<br/>';
        }
          





        $message = "updated";
    } else {
        // Insert new record
    $sql = "INSERT INTO careers (destination, skills, experience, location, destination_icon, created_by, status, created_at) 
        VALUES ('$destination', '$skills', '$experience', '$location', '$fileLinksImploded', '$log_name', '$status', '$create_at')";

if (!mysqli_query($db, $sql)) {
    die("Error executing INSERT query: " . mysqli_error($db));
}

// Fetch the newly inserted career ID
$selectQuery = "SELECT * FROM careers WHERE destination='$destination' and created_at='$create_at'";
$result = mysqli_query($db, $selectQuery);

if (!$result) {
    die("Error executing SELECT query: " . mysqli_error($db));
}

// Fetch the data
$selectData = mysqli_fetch_assoc($result);

if ($selectData) {
    $careers_id = $selectData['id'];
} else {
    die("No data found for the given destination and created_at.");
}

// Sanitize qualifications and responsibilities
$qualifications = isset($_POST['qualifications']) ? $_POST['qualifications'] : [];
$qualifications = array_map(function($qual) use ($db) {
    return mysqli_real_escape_string($db, $qual);
}, $qualifications);

$responsibilities = isset($_POST['responsibilities']) ? $_POST['responsibilities'] : [];
$responsibilities = array_map(function($resp) use ($db) {
    return mysqli_real_escape_string($db, $resp);
}, $responsibilities);

// Insert qualifications
if (is_array($qualifications) && !empty($qualifications)) {
    foreach ($qualifications as $qualification) {
        $query = "INSERT INTO qualifications (careers_id, destination, qualifications, create_by, create_at) 
                  VALUES ('$careers_id', '$destination', '$qualification', '$log_name', '$create_at')";
        if (!mysqli_query($db, $query)) {
            echo "Error inserting qualification: " . mysqli_error($db);
        } else {
            echo "Inserted qualification: $qualification<br/>";
        }
    }
} else {
    echo 'No qualifications provided.<br/>';
}


// Insert responsibilities
if (is_array($responsibilities) && !empty($responsibilities)) {
    foreach ($responsibilities as $responsibility) {
        $query = "INSERT INTO responsibilities (careers_id, destination, responsibilities, create_by, create_at) 
                  VALUES ('$careers_id', '$destination', '$responsibility', '$log_name', '$create_at')";
        if (!mysqli_query($db, $query)) {
            echo "Error inserting responsibility: " . mysqli_error($db);
        } else {
            echo "Inserted responsibility: $responsibility<br/>";
        }
    }
} else {
    echo 'No responsibilities provided.<br/>';
}
        $message = "added";

        // Redirect after successful operation
header("Location: career.php?success=$message");
exit();
    }
} else {
    if ($id > 0) {
        // Update existing record without image_file
        $sql = "UPDATE careers SET 
                destination='$destination', 
                skills='$skills', 
                experience='$experience', 
                location='$location', 
                updated_by='$log_name', 
                status='$status', 
                updated_at='$create_at' 
                WHERE id='$id'";

    
                // Sanitize qualifications and responsibilities
                $qualifications = isset($_POST['qualifications']) ? $_POST['qualifications'] : [];
                $qualifications_id = isset($_POST['qualifications_id']) ? $_POST['qualifications_id'] : [];

                $qualifications = array_map(function($qual) use ($db) {
                    return mysqli_real_escape_string($db, $qual);
                }, $qualifications);

                $responsibilities = isset($_POST['responsibilities']) ? $_POST['responsibilities'] : [];
                $responsibilities_id = isset($_POST['responsibilities_id']) ? $_POST['responsibilities_id'] : [];

                $responsibilities = array_map(function($resp) use ($db) {
                    return mysqli_real_escape_string($db, $resp);
                }, $responsibilities);

                // Insert qualifications
                if (is_array($qualifications) && !empty($qualifications)) {
                    foreach ($qualifications as $index => $qualification) {
                        $qualification_id = isset($qualifications_id[$index]) ? $qualifications_id[$index] : null;

                        // Escape variables to prevent SQL injection
                        $destination = mysqli_real_escape_string($db, $destination);
                        $qualification = mysqli_real_escape_string($db, $qualification);
                        $log_name = mysqli_real_escape_string($db, $log_name);
                        $create_at = mysqli_real_escape_string($db, $create_at);
                        $id = mysqli_real_escape_string($db, $id);

                        if ($qualification_id) {
                            $query = "UPDATE qualifications SET 
                                        destination='$destination', 
                                        qualifications='$qualification', 
                                        updated_by='$log_name',  
                                        updated_at='$create_at' 
                                        WHERE careers_id='$id' AND id='$qualification_id'";

                            if (!mysqli_query($db, $query)) {
                                echo "Error updating qualification: " . mysqli_error($db);
                            } else {
                                echo "Updated qualification: $qualification<br/>";
                            }
                        } else {
                            $query = "INSERT INTO qualifications (careers_id, destination, qualifications, create_by, create_at) 
                                    VALUES ('$id', '$destination', '$qualification', '$log_name', '$create_at')";

                            if (!mysqli_query($db, $query)) {
                                echo "Error inserting qualification: " . mysqli_error($db);
                            } else {
                                echo "Inserted qualification: $qualification<br/>";
                            }
                        }
                    }
                } else {
                    echo 'No qualifications provided.<br/>';
                }


                if (is_array($responsibilities) && !empty($responsibilities)) {
                    foreach ($responsibilities as $index => $responsibility) {
                        $responsibility_id = isset($responsibilities_id[$index]) ? $responsibilities_id[$index] : null;

                        // Escape variables to prevent SQL injection
                        $destination = mysqli_real_escape_string($db, $destination);
                        $responsibility = mysqli_real_escape_string($db, $responsibility);
                        $log_name = mysqli_real_escape_string($db, $log_name);
                        $create_at = mysqli_real_escape_string($db, $create_at);
                        $id = mysqli_real_escape_string($db, $id);

                        if ($responsibility_id) {
                            $query = "UPDATE responsibilities SET 
                                        destination='$destination', 
                                        responsibilities='$responsibility', 
                                        updated_by='$log_name',  
                                        updated_at='$create_at' 
                                        WHERE careers_id='$id' AND id='$responsibility_id'";

                            if (!mysqli_query($db, $query)) {
                                echo "Error updating responsibility: " . mysqli_error($db);
                            } else {
                                echo "Updated responsibility: $responsibility<br/>";
                            }
                        } else {
                            $query = "INSERT INTO responsibilities (careers_id, destination, responsibilities, create_by, create_at) 
                                    VALUES ('$id', '$destination', '$responsibility', '$log_name', '$create_at')";

                            if (!mysqli_query($db, $query)) {
                                echo "Error inserting responsibility: " . mysqli_error($db);
                            } else {
                                echo "Inserted responsibility: $responsibility<br/>";
                            }
                        }
                    }
                } else {
                    echo 'No responsibilities provided.<br/>';
                }






        $message = "updated";
    }
}

if (mysqli_query($db, $sql)) {
    echo "Record updated successfully.";
} else {
    echo "Error updating record: " . mysqli_error($db);
}



// Redirect after successful operation
header("Location: career.php?success=$message");
exit();
?>
