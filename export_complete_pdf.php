<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'vendor/autoload.php'; // This includes the Composer autoload file

require('fpdf.php'); // Include the FPDF library


include('connection.php');
// Start the session
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


$sql = "SELECT id, clientname, job, job_type, members, notes, completion, time_comp, reference, entry_date, assigned_by, job_status, filelink, job_close_file, close_time, cus_date FROM jobcreate WHERE id='2790'";

//   $sql = "SELECT id, clientname, job, job_type, members, notes, completion, time_comp, reference, entry_date, assigned_by, job_status, filelink, job_close_file, close_time, cus_date FROM jobcreate WHERE job_status='Closed Completed'";

$result = $db->query($sql);

if ($result->num_rows > 0) {

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
    
    $pdf->Cell(290, 5, '', 0, 1, 'C');
    $pdf->Cell(190, 40, '', 1, 0, 'C');
    $pdf->Image('assets/images/logo/icon.png', 12, 20, 20);
    
    $pdf->SetFont('Times', 'B', 15);
    $pdf->Cell(0);
    $pdf->Cell(-190, 15, 'Avatar Global Services', 0, 0, 'C');
    $pdf->SetFont('Times', '', 12);
    
    $pdf->SetFont('Times', '', 11);
    $pdf->Ln(7);
    $pdf->Cell(0, 15, '729 PKSA Road, Mahasakthi Building, Sivakasi ', 0, 0, 'C');
    $pdf->Ln(9);
    $pdf->Cell(0, 7, 'Phone no.: 9843479797', 0, 0, 'C');
    $pdf->Ln(7);
    $pdf->Cell(0, 2, 'Email: business@avatarprints.com', 0, 0, 'C');
    $pdf->Ln(6);
    $pdf->Cell(0, 3, 'GSTIN: 33AZGPM5829A1ZM', 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 3, 'State: 33-Tamil Nadu', 0, 0, 'C');
    $pdf->Ln(7);

    $pdf->Cell(0, 0, '', 0, 1, 'C');
    $pdf->Ln(0);

    $i = 1;
    while ($row = $result->fetch_assoc()) {
        
        $clientname = ucfirst($row['clientname']);
        $capitalizedJob = ucfirst($row['job']);
        $job_type = ucfirst($row['job_type']);
        $filelink = $row['filelink'];
        
        $pdf->SetFont('', 'BU', 13);
        $pdf->Cell(40, 7, 'CLIENT NAME :', 0, 0);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0, 7, $clientname, 0, 0);
        $pdf->Ln();
        
        $pdf->SetFont('', 'BU', 13);
        $pdf->Cell(30, 7, 'JOB NAME :', 0, 0);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0, 7, $capitalizedJob, 0, 0);
        $pdf->Ln();

        $pdf->SetFont('', 'BU', 13);
        $pdf->Cell(30, 7, 'JOB TYPE :', 0, 0);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0, 7, $job_type, 0, 0);
        $pdf->Ln();

        if (!empty($filelink)) {
            $pdf->SetFont('', 'BU', 13);
            $pdf->Cell(30, 7, 'File Link :', 0, 0);
            $pdf->SetFont('Times', '', 13);
            $pdf->Cell(0, 7, $filelink, 0, 0);
            $pdf->Ln();
        }
        
        $job_close_files1 = $row["job_close_file"];
        if (!empty($job_close_files1)) {
            $job_close_files = explode("\n", $job_close_files1);
            
            $pdf->SetFont('', 'BU', 13);
            $pdf->Cell(30, 7, 'Output :', 0, 0);
            $pdf->Ln();

            $imageCount = 0; // Counter for images in the current row

            // Define the document root (adjust if necessary)
            $documentRoot = $_SERVER['DOCUMENT_ROOT'] . '/avatarjobs/clientfiles/';

            foreach ($job_close_files as $job_close_file) {
                // Remove any extraneous whitespace from the file path
                $job_close_file = trim($job_close_file);
                if (empty($job_close_file)) {
                    continue; // Skip empty lines
                }

                // Convert URL to local path if necessary
                $local_file_path = str_replace('https://avatarglobalservices.com/avatarjobs/clientfiles/', $documentRoot, $job_close_file);

                // Set the width of the image (adjust as needed)
                $imageWidth = 70;

                // Check if the file exists before attempting to get its dimensions
                if (file_exists($local_file_path)) {
                    list($width, $height) = getimagesize($local_file_path);
                    
                    // Ensure width and height are non-zero
                    if ($width > 0 && $height > 0) {
                        $maxImagesPerPage = 10; // Set your desired maximum images per page

        if ($imageCount > 0 && $imageCount % $maxImagesPerPage == 0) {
            // Create a new page
            $pdf->AddPage();
        }

                        $imageHeight = ($imageWidth / $width) * $height;

                        if ($imageCount > 0 && $imageCount % 2 == 0) {
                            // Move to next row after every two images
                            $pdf->Ln($imageHeight + 10);
                            $pdf->AddPage();
                        }

                        // Get the current X and Y position
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
                    // Log error message instead of echoing it
                    // error_log("File does not exist: $local_file_path");
                    
                    $pdf->SetFont('', 'BU', 13);
                    $pdf->Cell(30, 7, 'Imagesss:', 0, 0);
                    $pdf->SetFont('Times', '', 13);
                    $pdf->Cell(0, 7, 'No Data', 0, 1);
                }
            }

            // Move to the next line if the number of images is odd
            if ($imageCount % 2 != 0) {
                $pdf->Ln($imageHeight + 10);
            }
        } 
        else {
            $pdf->SetFont('', 'BU', 13);
            $pdf->Cell(30, 7, 'Output:', 0, 0);
            $pdf->SetFont('Times', '', 13);
            $pdf->Cell(0, 7, 'No Data', 0, 1);
        }
         $pdf->Ln();
          $pdf->Ln();
    }

    // Ensure no output has been sent to the browser before this point
    ob_start();
//       $currentTime = date("Ymd_His"); // Current date and time formatted as YYYYmmdd_HHMMSS
// $outputFilename ="report_output_" . $currentTime . ".pdf";

// $pdf->Output($outputFilename, 'D');
$pdf->output();
    ob_end_flush();
    exit;

        $pdf->Ln();
        $i++;
    }


$db->close();




?>