<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'vendor/autoload.php'; // This includes the Composer autoload file

require('fpdf.php'); // Include the FPDF library


include('connection.php');

session_start();

$log_name=$_SESSION["uname"];

$name_member = "SELECT * FROM members WHERE username = '$log_name'";
$result = mysqli_query($db, $name_member);

if ($result) {
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);
        
        // Access the 'name' column from the result
        $name_member = $row['fname'];
        $name_member_id = $row['id'];
        
        // Output the name
        // echo $name_member;
        // die;
    }
}

$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];

$clientname=$_POST['clientname'];


  $sql = "SELECT *
  FROM jobcreate
  WHERE job_status = 'Closed Completed'
  AND completion >= '$start_date' 
    AND completion < '$end_date' 
    AND clientname = '$clientname'
    ORDER BY entry_date, start_time ASC";
    
    
    $sql_count = "SELECT COUNT(*) as count 
    FROM jobcreate 
    WHERE job_status = 'Closed Completed' 
    AND completion >= '$start_date' 
    AND completion < '$end_date' 
    AND clientname = '$clientname'
    ORDER BY entry_date, start_time ASC";


$result_count = $db->query($sql_count);


if ($result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $count_job = $row_count['count'];
   
} 
    
    
// print_r($sql);
// exit;
$result = $db->query($sql);

if ($result->num_rows > 0) {
    
       function is_image_file($file_path) {
        $allowed_formats = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'webp'];
        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        return in_array($file_extension, $allowed_formats);
    }

    class PDF extends FPDF {
        function Footer()
        {
            $this->SetY(-24);
            $this->Cell(190, 5, '', 0, 1, 'C');
            $this->Cell(90);
            $this->SetFont('Times', '', 10);
            $this->Cell(50, 0, 'Page No :   ' . $this->PageNo(), 0, 0);
            $this->Cell(-90);
            $this->Cell(-150);
        }
    }

    // Create new PDF document
  $pdf = new FPDF();
$pdf->AddPage();

// Set cell for the strip
$pdf->Cell(290, 5, '', 0, 0, 'C');
$pdf->Cell(190, 40, '', 1, 0, 'C');

// Place the image at the top of the strip
$pdf->Image('assets/images/avatar_pdf.jpg', 12, 10, 200, 42);

date_default_timezone_set("Asia/Calcutta");
$date = date("d/m/Y");
$time = date("H:i:s");

$pageWidth = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

$pdf->Ln();

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'Date : ' . $date, 0, 1, 'L');
$pdf->Ln(10);

$lineHeight = 10;
$cellHeight1 = 17;
$cellHeight2 = 7;
$cellHeight3 = 17;
$cellHeight4 = 17;
$cellHeight5 = 2;
$totalHeight = $lineHeight + $cellHeight1 + $lineHeight + $cellHeight2 + $lineHeight + $cellHeight3;

$startY = ($pageHeight - $totalHeight) / 2;

// Move to the calculated starting Y position
$pdf->SetY($startY);

$sql2 = "SELECT * FROM members WHERE id = '$member_name'";
$result2 = $db->query($sql2);


$sql_clinets = "SELECT * FROM clients WHERE name = '$clientname'";
$result2 = $db->query($sql_clinets);

if ($result2 && $result2->num_rows > 0) {
    $row = $result2->fetch_assoc();
    $profile_picture = $row['profile_picture'];

    // Check if the profile picture file exists and is an image
    if (file_exists($profile_picture) && is_image_file($profile_picture)) {
  

        // Add the image centered on the page
        $pdf->Image($profile_picture, 58, 40, 85, 0, '', '', 'C'); // Adjust coordinates as needed
    } else {
        // Handle case where the image is not found or not valid
        $pdf->SetFont('Times', '', 24);
        $pdf->Cell(0, 10, $clientname, 0, 1, 'C');
    }
}
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Helvetica', 'B', 20);
$pdf->Cell(0, $cellHeight2, 'Report for the Duration of  ', 0, 1, 'C');
$pdf->Ln($lineHeight);

$pdf->SetFont('Helvetica', '', 22);
$pdf->Cell(0, 5, $start_date . ' To ' . $end_date, 0, 1, 'C');

$sql_time = "SELECT * FROM jobcreate WHERE job_status = 'Closed Completed' AND completion >= '$start_date' AND completion < '$end_date' AND clientname = '$clientname'";
$result_time = $db->query($sql_time);

// Calculate total time taken
$totalWorkingSeconds = 0;
while ($row_time = $result_time->fetch_assoc()) {
    $start_time = $row_time['job_start_at'];
    $close_time = $row_time['close_time'];
    $job_pause_at = $row_time['job_pause_at'];
    $job_start_again = $row_time['job_start_again'];

    // Normal working intervals (start to pause or close)
    if (!empty($start_time)) {
        $startDateTime = new DateTime($start_time);

        if (!empty($job_pause_at)) {
            $pauseDateTime = new DateTime($job_pause_at);
            $interval = $startDateTime->diff($pauseDateTime);
        } else {
            $closeDateTime = new DateTime($close_time);
            $interval = $startDateTime->diff($closeDateTime);
        }
        $totalWorkingSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
    }

    // Paused intervals (pause to restart)
    if (!empty($job_pause_at) && !empty($job_start_again)) {
        $pauseDateTime = new DateTime($job_pause_at);
        $startAgainDateTime = new DateTime($job_start_again);
        $interval = $pauseDateTime->diff($startAgainDateTime);
        $totalPausedSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
    }

    // Additional working time after pause
    if (!empty($job_start_again) && !empty($close_time)) {
        $startAgainDateTime = new DateTime($job_start_again);
        $closeDateTime = new DateTime($close_time);
        $interval = $startAgainDateTime->diff($closeDateTime);
        $totalWorkingSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
    }
}

// Convert total seconds to hours, minutes, and seconds
$hours = floor($totalWorkingSeconds / 3600);
// $minutes = 1;
$minutes = floor(($totalWorkingSeconds / 60) % 60);
$seconds = $totalWorkingSeconds % 60;

// Prepare total working time string
if ($hours > 0) {
    $totalWorkingTime = sprintf("%d Hours %d Minutes and %d Seconds", $hours, $minutes, $seconds);
} else {
    $totalWorkingTime = sprintf("%d Minutes and %d Seconds", $minutes, $seconds);
}

$pdf->SetFont('Helvetica', 'BU', 19);
$pdf->Cell(0, $cellHeight4, 'Total Working Time ', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 20);
$pdf->Cell(0, $cellHeight4, $totalWorkingTime, 0, 1, 'C');

$pdf->AddPage();

$sql_time2 = "SELECT * FROM jobcreate WHERE job_status = 'Closed Completed' AND completion >= '$start_date' AND completion < '$end_date' AND clientname = '$clientname'";
$result_time2 = $db->query($sql_time2);

// Initialize an array to store total time per job type
$totalTimesByJobType = [];
$sno = 1;
// Calculate total time taken
while ($row_time2 = $result_time2->fetch_assoc()) {
    $start_time2 = $row_time2['job_start_at'];
    $close_time2 = $row_time2['close_time'];
    $job_type = $row_time2['job_type'];
    $job_pause_at = $row_time2['job_pause_at'];
    $job_start_again = $row_time2['job_start_again'];

    $totalWorkingSeconds = 0;
    $totalPausedSeconds = 0;

    if (!empty($start_time2) && !empty($close_time2)) {
        $startDateTime2 = new DateTime($start_time2);
        $closeDateTime2 = new DateTime($close_time2);
        $interval2 = $startDateTime2->diff($closeDateTime2);
        $totalWorkingSeconds = $interval2->s + $interval2->i * 60 + $interval2->h * 3600;

        // If there are pause and resume times, adjust the working time accordingly
        if (!empty($job_pause_at) && !empty($job_start_again)) {
            $pauseDateTime = new DateTime($job_pause_at);
            $startAgainDateTime = new DateTime($job_start_again);
            $intervalPause = $pauseDateTime->diff($startAgainDateTime);
            $totalPausedSeconds = $intervalPause->s + $intervalPause->i * 60 + $intervalPause->h * 3600;

            // Deduct paused time from the total working time
            $totalWorkingSeconds -= $totalPausedSeconds;
        }

        // Accumulate total working time for each job type
        if (!isset($totalTimesByJobType[$job_type])) {
            $totalTimesByJobType[$job_type] = 0;
        }
        $totalTimesByJobType[$job_type] += $totalWorkingSeconds;
    }
}

// Set up table header
$pdf->SetFont('Helvetica', 'B', 13);
$pdf->Cell(15, $cellHeight4, 'S.No', 1, 0, 'C');
$pdf->Cell(70, $cellHeight4, 'Job Type', 1, 0, 'C');
$pdf->Cell(0, $cellHeight4, 'Time Taken', 1, 1, 'C');

// Convert and print total time for each job type
foreach ($totalTimesByJobType as $job_type => $totalSeconds) {
 
$hours = floor($totalSeconds / 3600);
$minutes = floor(($totalSeconds % 3600) / 60); 
$seconds = $totalSeconds % 60;

// Prepare total working time string
if ($hours > 0) {
    // echo $hours;
    // exit;
    $totalWorkingTime2 = sprintf("%d Hours %d Minutes and %d Seconds", $hours, $minutes, $seconds);
} else {
    $totalWorkingTime2 = sprintf("%d Minutes and %d Seconds", $minutes, $seconds);
}

    $pdf->SetFont('Helvetica', '', 13);
    $pdf->Cell(15, $cellHeight4, $sno, 1, 0, 'C');
    $pdf->Cell(70, $cellHeight4, $job_type, 1, 0, 'C');
    $pdf->Cell(0, $cellHeight4, $totalWorkingTime2, 1, 1, 'C');

    $sno++;
}


       $pdf->AddPage();  
       
    $i = 1;
     $count_no=1;
     $watermarkImg = 'client_dp/avatar.png';
    while ($row = $result->fetch_assoc()) {
        
        $clientname = ucfirst($row['clientname']);
        $capitalizedJob = ucfirst($row['job']);
            $job_type = ucfirst($row['job_type']);
            $filelink = $row['filelink'];
            $completion = $row['completion'];
            $members = $row['members'];
            $entry_date = $row['entry_date'];
            $close_time = $row['close_time'];
            $closing_date = date('M d, Y', strtotime($close_time));
    
            $job_status = $row['job_status'];
            $type_of_work = $row['type_of_work'];
            $start_time=$row['job_start_at'];
            $notes_output=$row['notes_output'];
            
            
         
            $lineHeight = 5;
    
            $pdf->SetFont('', 'B', 13);
            $pdf->Cell(40, $lineHeight, 'Job No ', 0, 0);
            $pdf->SetFont('Helvetica', '', 13);
            $pdf->Cell(0, $lineHeight, ': '.$count_no, 0, 1);
            $pdf->Ln($lineHeight / 2);
            $pdf->SetFont('', 'B', 13);
            $pdf->Cell(40, $lineHeight, 'Job Name ', 0, 0);
            $pdf->SetFont('Helvetica', '', 13);
            $pdf->Cell(0, $lineHeight, ': '.$capitalizedJob, 0, 1);
            $pdf->Ln($lineHeight / 2);
    
            $pdf->SetFont('', 'B', 13);
            $pdf->Cell(40, $lineHeight, 'Job Type ', 0, 0);
            $pdf->SetFont('Helvetica', '', 13);
            $pdf->Cell(0, $lineHeight, ': '.$job_type, 0, 1);
            $pdf->Ln($lineHeight / 2);
    
            $pdf->SetFont('', 'B', 13);
            $pdf->Cell(40, $lineHeight, 'Type of Work ', 0, 0);
            $pdf->SetFont('Helvetica', '', 13);
            $pdf->Cell(0, $lineHeight, ': '.$type_of_work, 0, 1);
            $pdf->Ln($lineHeight / 2);
            
            // $pdf->SetFont('', 'B', 13);
            // $pdf->Cell(40, $lineHeight, 'Job Creation ', 0, 0);
            // $pdf->SetFont('Helvetica', '', 13);
            // $pdf->Cell(0, $lineHeight, ': '.$entry_date, 0, 1);
            // $pdf->Ln($lineHeight / 2);
    
      
    
            // if (!empty($start_time)) {
            //     $pdf->SetFont('', 'B', 13);
            //     $pdf->Cell(40, $lineHeight, 'Job Started at ', 0, 0);
            //     $pdf->SetFont('Helvetica', '', 13);
            //     $pdf->Cell(0, $lineHeight, ': '.$start_time, 0, 1);
            //     $pdf->Ln($lineHeight / 2);
            // }
            
            if (!empty($job_status)) {
                $pdf->SetFont('', 'B', 13);
                $pdf->Cell(40, $lineHeight, 'Delivery Date ', 0, 0);
                $pdf->SetFont('Helvetica', '', 13);
                $pdf->Cell(0, $lineHeight, ': '. $closing_date, 0, 1);
                $pdf->Ln($lineHeight / 2);
            }

        
            $totalDays = 0;
            $totalHours = 0;
            $totalMinutes = 0;
            $totalSeconds = 0;
            
            if (!empty($start_time)) {
            
                $start_time = $row['job_start_at'];
                $close_time = $row['close_time'];
                $job_pause_at = $row['job_pause_at'];
                $job_start_again = $row['job_start_again'];
            
                if (!empty($job_start_again) && !empty($job_pause_at)) {
                    // Calculate the first interval from job start to first pause
                    if (!empty($start_time) && !empty($job_pause_at)) {
                        $startDateTime = new DateTime($start_time);
                        $pauseDateTime = new DateTime($job_pause_at);
                        $interval = $startDateTime->diff($pauseDateTime);
            
                        $totalDays += $interval->d;
                        $totalHours += $interval->h;
                        $totalMinutes += $interval->i;
                        $totalSeconds += $interval->s;
                    }
            
                    // Calculate the interval from job restart to job close
                    if (!empty($job_start_again) && !empty($close_time)) {
                        $startAgainDateTime = new DateTime($job_start_again);
                        $closeDateTime = new DateTime($close_time);
                        $interval = $startAgainDateTime->diff($closeDateTime);
            
                        $totalDays += $interval->d;
                        $totalHours += $interval->h;
                        $totalMinutes += $interval->i;
                        $totalSeconds += $interval->s;
                    }
            
                    // Adjust total minutes and hours if seconds or minutes overflow
                    $totalMinutes += intdiv($totalSeconds, 60);
                    $totalSeconds %= 60;
                    $totalHours += intdiv($totalMinutes, 60);
                    $totalMinutes %= 60;
                    $totalDays += intdiv($totalHours, 24);
                    $totalHours %= 24;
            
                    // Format the total duration
                    if ($totalDays > 0) {
                        $timeDifference = "{$totalDays} days {$totalHours} hours {$totalMinutes} minutes {$totalSeconds} seconds";
                    } elseif ($totalHours > 0) {
                        $timeDifference = "{$totalHours} hours {$totalMinutes} minutes {$totalSeconds} seconds";
                    } else {
                        $timeDifference = "{$totalMinutes} minutes {$totalSeconds} seconds";
                    }
            
                    $pdf->SetFont('', 'B', 13);
                    $pdf->Cell(40, $lineHeight, 'Time Taken  ', 0, 0);
                    $pdf->SetFont('Helvetica', '', 13);
                    $pdf->Cell(0, $lineHeight, ': ' . $timeDifference, 0, 1);
                    $pdf->Ln($lineHeight / 2);
                } else {
                    if (!empty($start_time) && !empty($close_time)) {
                        $startDateTime = new DateTime($start_time);
                        $closeDateTime = new DateTime($close_time);
                        $interval = $startDateTime->diff($closeDateTime);
            
                        if ($interval->d > 0) {
                            $timeDifference = $interval->format('%d days %h hours %i minutes %s seconds');
                        } elseif ($interval->h > 0) {
                            $timeDifference = $interval->format('%h hours %i minutes %s seconds');
                        } else {
                            $timeDifference = $interval->format('%i minutes %s seconds');
                        }
            
                        $pdf->SetFont('', 'B', 13);
                        $pdf->Cell(40, $lineHeight, 'Time Taken  ', 0, 0);
                        $pdf->SetFont('Helvetica', '', 13);
                        $pdf->Cell(0, $lineHeight, ': ' . $timeDifference, 0, 1);
                        $pdf->Ln($lineHeight / 2);
                    }
                }
            }
            

            // if (!empty($start_time)) {
           

            //        // Calculate the time difference
            // $startDateTime = new DateTime($start_time);
            // $closeDateTime = new DateTime($close_time);
            // $interval = $startDateTime->diff($closeDateTime);

            // // Conditional formatting of time difference
            // if ($interval->d > 0) {
            //     $timeDifference = $interval->format('%d days %h hours %i minutes %s seconds');
            // } elseif ($interval->h > 0) {
            //     $timeDifference = $interval->format('%h hours %i minutes %s seconds');
            // } else {
            //     $timeDifference = $interval->format('%i minutes %s seconds');
            // }

            //     $pdf->SetFont('', 'B', 13);
            //     $pdf->Cell(40, $lineHeight, 'Time Taken  ', 0, 0);
            //     $pdf->SetFont('Helvetica', '', 13);
            //     $pdf->Cell(0, $lineHeight, ': '.$timeDifference, 0, 1);
            //     $pdf->Ln($lineHeight / 2);
            // }
    
            // $pdf->SetFont('', 'B', 13);
            // $pdf->Cell(40, $lineHeight, 'Job Status :', 0, 0);
            // $pdf->SetFont('Helvetica', '', 13);
            
            // if (!empty($job_status)) {
            //     $pdf->Cell(0, $lineHeight, ': Completed', 0, 1);
            // } else {
            //     $pdf->Cell(0, $lineHeight, ': Pending', 0, 1);
            // }
    
            $pdf->Ln($lineHeight / 2);
    
            if (!empty($filelink)) {
                $pdf->SetFont('', 'BU', 13);
                $pdf->Cell(40, $lineHeight, 'File Link :', 0, 1);
                $pdf->SetFont('Helvetica', '', 13);
                
                $pdf->MultiCell(0, $lineHeight, $filelink, 0, 'L'); 
                $pdf->Ln($lineHeight / 2);
            }

            $sql2 = "SELECT *   FROM members   WHERE id = '$members'";
            $result2 = $db->query($sql2);
    
        //  if ($result2->num_rows > 0) {
        //         $row2 = $result2->fetch_assoc();
        //         $member_name = $row2['fname'] . ' ' . $row2['lname'];
        //         $pdf->SetFont('', 'B', 13);
        //         $pdf->Cell(40, $lineHeight, 'Worked by ', 0, 0);
        //         $pdf->SetFont('Helvetica', '', 13);
        //         $pdf->MultiCell(0, $lineHeight,': '. $member_name, 0, 'L');
        //         // $pdf->Cell(0, $lineHeight, $member_name, 0, 0);
        //         $pdf->Ln($lineHeight / 2);
        //     }
    
        
        $job_close_files1 = $row["job_close_file"];
        if (!empty($job_close_files1)) {
            $job_close_files = explode("\n", $job_close_files1);
            $pdf->SetFont('Helvetica', 'BU', 13);
            $pdf->Cell(40, 7, 'OUTPUT :', 0, 1);
            
            $imageCount = 0; 
            $documentRoot = $_SERVER['DOCUMENT_ROOT'] . '/avatarjobs/clientfiles/';
        
            foreach ($job_close_files as $job_close_file) {
                $job_close_file = trim($job_close_file);
                if (empty($job_close_file)) {
                    continue; 
                }
        
                $local_file_path = str_replace('https://avatarglobalservices.com/avatarjobs/clientfiles/', $documentRoot, $job_close_file);
        
                if (file_exists($local_file_path)) {
                    if (is_image_file($local_file_path)) {
                        list($width, $height) = getimagesize($local_file_path);
                        if ($width > 0 && $height > 0) {
                            $imageWidth = 70;
                            $imageHeight = ($imageWidth / $width) * $height;
        
                            if ($imageCount > 0 && $imageCount % 4 == 0) {
                                $pdf->AddPage();
                                
                                $pdf->SetY(10);
                            }
                          

                            $x = $pdf->GetX();
                            $y = $pdf->GetY();
        
                            $pdf->Image($local_file_path, $x, $y, $imageWidth, $imageHeight);
        
                            if ($imageCount % 2 == 0) {
                                $pdf->SetX($x + $imageWidth + 10);
                            } else {
                                $pdf->Ln($imageHeight + 10);
                            }
        
                            $imageCount++;
                        }
                    } else {
                        $pdf->SetFont('Helvetica', 'BU', 13);
                        $pdf->Cell(40, $lineHeight, 'File Link:', 0, 0);
                        $pdf->SetFont('Helvetica', '', 13);
                        $pdf->Ln();
                        $pdf->Cell(0, $lineHeight, $job_close_file, 0, 1, $local_file_path);
                    }
                }
            }
        
            if ($imageCount % 2 != 0) {
                $pdf->Ln($imageHeight + 10);
            }
        }
        
        
           if(!empty($notes_output))
            {
                
                $pdf->SetFont('', 'BU', 13);
                $pdf->Cell(40, $lineHeight, 'Output Notes ', 0, 0);
                $pdf->SetFont('Helvetica', '', 13);
                $pdf->MultiCell(0, $lineHeight, $notes_output, 0, 'L');
                // $pdf->Cell(0, $lineHeight, ': '.$notes_output, 0, 1);
                $pdf->Ln($lineHeight / 2);
            }
        // else {
        //     $pdf->SetFont('', 'BU', 13);
        //     $pdf->Cell(30, 7, 'Images:', 0, 0);
        //     $pdf->SetFont('Times', '', 13);
        //     $pdf->Cell(0, 7, 'No Data', 0, 1);
        // }
         $pdf->Ln();
          $pdf->Ln();
           $pdf->Ln();
          
       if ($result->num_rows > $count_no) {
            $pdf->AddPage();
        }  
      $count_no++;
    }
  

    ob_start();
    
     $dateStart = new DateTime($start_date);
    $dateEnd = new DateTime($end_date);
    // $pdf->Output();
    // exit;
    // Format the dates
    $formattedDateStart = $dateStart->format('F_j_Y');  // Full textual representation of the month, day of the month, and full year
    $formattedDateStart = strtolower($formattedDateStart); // Convert to lowercase
    
    $formattedDateEnd = $dateEnd->format('F_j_Y');  // Full textual representation of the month, day of the month, and full year
    $formattedDateEnd = strtolower($formattedDateEnd); // Convert to lowercase

    $currentTime = date("His");
    $outputFilename = $clientname . "_" . $formattedDateStart . "_to_" . $formattedDateEnd . "_" . $currentTime . ".pdf";
    
        // Generate the PDF output
    $pdf->Output($outputFilename, 'D');
    
    ob_end_flush();
    // exit;

        $i++;
    }
    else {
       echo '<script>
    alert("No Data Found - Enter Other Valid Data");
    window.location.href = "export_pdf.php";
    </script>';

    }



$db->close();




?>