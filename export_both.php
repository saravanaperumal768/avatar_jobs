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
$members=$_POST['member_name'];


// if($members =='0'){
//     echo '<script>
//     alert("Select Members Name Properly");
//     window.location.href = "export_pdf.php";
//     </script>';
// }

// if($clientname =='0'){
//     echo '<script>
//     alert("Select Client Name Properly");
//     window.location.href = "export_pdf.php";
//     </script>';
// }

if($clientname =='0' || $members =='0'){
    echo '<script>
    alert("Select Client Name And Members Name Properly");
    window.location.href = "export_pdf.php";
    </script>';
}

    $sql = "SELECT *
    FROM jobcreate
    WHERE job_status = 'Closed Completed'
    AND completion >= '$start_date' 
        AND completion < '$end_date' 
        AND clientname = '$clientname'
        AND members = '$members'
    ORDER BY entry_date, start_time ASC";

    
    
    $sql_count = "SELECT COUNT(*) as count 
    FROM jobcreate 
    WHERE job_status = 'Closed Completed' 
    AND completion >= '$start_date' 
    AND completion <= '$end_date' 
    AND clientname = '$clientname'
    AND members = '$members'
    ORDER BY completion, start_time ASC";


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
            
    date_default_timezone_set("Asia/calcutta");
    $date = date("d/m/Y");
    $tim = date("H:i:s");  
        
    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    date_default_timezone_set("Asia/Calcutta");
    $date = date("d/m/Y");
    $time = date("H:i:s");

    $pdf->Ln();
    
    $pdf->SetFont('Times','B',14);
    $pdf->Cell(0, 5, 'Date : ' . $date, 0, 1, 'L');
    $pdf->Ln($lineHeight);
    
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



    $sql2 = "SELECT * FROM members WHERE id = '$members'";
    $result2 = $db->query($sql2);

    $pdf->SetFont('', 'B', 25);
    $pdf->Cell(80, 17, 'Client Name', 0, 0, 'R'); 
    $pdf->SetFont('Times', '', 27);
    $pdf->Cell(180, 17,': '. $clientname, 0, 1,'L'); // Set ln parameter to 1 to move to the next line
    $pdf->Ln(9);

    $pdf->SetFont('', 'B', 25);
    $pdf->Cell(80, 17, 'Member Name', 0, 0, 'R');
    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $member_name1 = $row2['fname'] . ' ' . $row2['lname'];
        $pdf->SetFont('Times', '', 27);
        $pdf->Cell(0, $cellHeight1,': '.$member_name1, 0, 1, 'L');
        $pdf->Ln($lineHeight);
    }

    $pdf->SetFont('Helvetica', 'B', 24);
    $pdf->Cell(80, 17, 'Report Between', 0, 0, 'R'); 
    $pdf->SetFont('Helvetica', '', 24);
    $pdf->Cell(180, 17,': '.  $start_date . ' To ' . $end_date, 0, 1,'L'); // Set ln parameter to 1 to move to the next line
    $pdf->Ln(9);
        
        //   $pdf->SetFont('', 'B', 13);
        // $pdf->Cell(40, 7, 'Total Job Count  :', 0, 0, 'C'); 
        // $pdf->SetFont('Times', '', 23);
        // $pdf->Cell(180, 27, $count_job.' Jobs', 0, 1,'C'); 
        // $pdf->Ln();

        $sql_time = "SELECT *
        FROM jobcreate
        WHERE job_status = 'Closed Completed'
        AND completion >= '$start_date' 
          AND completion <= '$end_date' 
          AND clientname = '$clientname'
          AND members = '$members'";

          $result_time = $db->query($sql_time);
          // Calculate total time taken
          while ($row_time = $result_time->fetch_assoc()) {
              $start_time = $row_time['job_start_at'];
              $close_time = $row_time['close_time'];
      
              if (!empty($start_time) && !empty($close_time)) {
                  $startDateTime = new DateTime($start_time);
                  $closeDateTime = new DateTime($close_time);
                  $interval = $startDateTime->diff($closeDateTime);
                  $totalWorkingSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
              }
          }
      
      
          // Convert total seconds to hours, minutes, and seconds
          $hours = floor($totalWorkingSeconds / 3600);
          $minutes = floor(($totalWorkingSeconds / 60) % 60);
          $seconds = $totalWorkingSeconds % 60;
      
          // Prepare total working time string
          if ($hours > 0) {
              $totalWorkingTime = sprintf("%d Hours %d Minutes and %d Seconds", $hours, $minutes, $seconds);
          } else {
              $totalWorkingTime = sprintf("%d Minutes and %d Seconds", $minutes, $seconds);
          }
      
          // $totalWorkingTime = gmdate("H:i:s", $totalWorkingSeconds);
          $pdf->SetFont('Helvetica', 'BU', 20);
          $pdf->Cell(0, $cellHeight4, 'Total Working Time :', 0, 1, 'C');
          $pdf->SetFont('Helvetica', '', 20);
          $pdf->Cell(0, $cellHeight4, $totalWorkingTime, 0, 1, 'C');
       
       $pdf->AddPage();   
    $i = 1;
     $count_no=1;
    while ($row = $result->fetch_assoc()) {
        
        $clientname = ucfirst($row['clientname']);
        $capitalizedJob = ucfirst($row['job']);
            $job_type = ucfirst($row['job_type']);
            $filelink = $row['filelink'];
            $completion = $row['completion'];
            $members = $row['members'];
            $entry_date = $row['entry_date'];
            $close_time = $row['close_time'];
    
            $job_status = $row['job_status'];
            $type_of_work = $row['type_of_work'];
            $start_time=$row['job_start_at'];
            $notes_output=$row['notes_output'];
         
            $lineHeight = 5;
    
            $pdf->SetFont('Helvetica', 'B', 13);
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
            
            $pdf->SetFont('', 'B', 13);
            $pdf->Cell(40, $lineHeight, 'Job Creation ', 0, 0);
            $pdf->SetFont('Helvetica', '', 13);
            $pdf->Cell(0, $lineHeight, ': '.$entry_date, 0, 1);
            $pdf->Ln($lineHeight / 2);
    
      
    
            if (!empty($start_time)) {
                $pdf->SetFont('', 'B', 13);
                $pdf->Cell(40, $lineHeight, 'Job Started at ', 0, 0);
                $pdf->SetFont('Helvetica', '', 13);
                $pdf->Cell(0, $lineHeight, ': '.$start_time, 0, 1);
                $pdf->Ln($lineHeight / 2);
            }
            
            if (!empty($job_status)) {
                $pdf->SetFont('', 'B', 13);
                $pdf->Cell(40, $lineHeight, 'Job Completion ', 0, 0);
                $pdf->SetFont('Helvetica', '', 13);
                $pdf->Cell(0, $lineHeight, ': '.$close_time, 0, 1);
                $pdf->Ln($lineHeight / 2);
            }

            if (!empty($start_time)) {
                // $startDateTime = new DateTime($start_time);
                // $closeDateTime = new DateTime($close_time);
                // $interval = $startDateTime->diff($closeDateTime);
                // $timeDifference = $interval->format('%d days %h hours %i minutes %s seconds');

                   // Calculate the time difference
            $startDateTime = new DateTime($start_time);
            $closeDateTime = new DateTime($close_time);
            $interval = $startDateTime->diff($closeDateTime);

            // Conditional formatting of time difference
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
                $pdf->Cell(0, $lineHeight, ': '.$timeDifference, 0, 1);
                $pdf->Ln($lineHeight / 2);
            }
    
            $pdf->SetFont('', 'B', 13);
            $pdf->Cell(40, $lineHeight, 'Job Status :', 0, 0);
            $pdf->SetFont('Helvetica', '', 13);
            
            if (!empty($job_status)) {
                $pdf->Cell(0, $lineHeight, ': Completed', 0, 1);
            } else {
                $pdf->Cell(0, $lineHeight, ': Pending', 0, 1);
            }
    
            $pdf->Ln($lineHeight / 2);
    
            if (!empty($filelink)) {
                $pdf->SetFont('', 'BU', 13);
                $pdf->Cell(40, $lineHeight, 'File Link :', 0, 1);
                $pdf->SetFont('Helvetica', '', 13);
                
                $pdf->MultiCell(0, $lineHeight, $filelink, 0, 'L'); // Use MultiCell for better handling of long links
                $pdf->Ln($lineHeight / 2);
            }

      
    
        
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
                $pdf->Cell(0, $lineHeight, ': '.$notes_output, 0, 1);
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

    // $pdf->output();
    // exit;

    $dateStart = new DateTime($start_date);
    $dateEnd = new DateTime($end_date);
    
    // Format the dates
    $formattedDateStart = $dateStart->format('F_j_Y');  // Full textual representation of the month, day of the month, and full year
    $formattedDateStart = strtolower($formattedDateStart); // Convert to lowercase
    
    $formattedDateEnd = $dateEnd->format('F_j_Y');  // Full textual representation of the month, day of the month, and full year
    $formattedDateEnd = strtolower($formattedDateEnd); // Convert to lowercase

        $sql2 = "SELECT *   FROM members WHERE id = '$members'";
    $result2 = $db->query($sql2);

 if ($result2->num_rows > 0) {
//    $pdf->output();
//    exit;
        $row2 = $result2->fetch_assoc();
        $member_name1 = $row2['fname'] . ' ' . $row2['lname'];
        $currentTime = date("His");
        $outputFilename = $clientname."_".$member_name1 . "_" . $formattedDateStart . "_to_" . $formattedDateEnd . "_" . $currentTime . ".pdf";
    
        // Generate the PDF output
        $pdf->Output($outputFilename, 'D');
}
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