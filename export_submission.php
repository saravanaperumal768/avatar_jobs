<?php
include("connection.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
// echo $log_name;
// exit;
// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Fetch data from your database table
$sql = "SELECT id, clientname, job, members, notes, completion, time_comp, reference, entry_date, assigned_by, job_status, close_time, cus_date  FROM jobcreate WHERE members = '$name_member_id'"  ; // Replace 'your_table' with your actual table name
// echo $sql;
// exit;
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Output field names as bold and uppercase
    $columnIndex = 1;
    $rowIndex = 1;
    $fields = [];
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $fieldName => $cellValue) {
            if (!in_array($fieldName, $fields)) {
                $fields[] = $fieldName;
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, strtoupper($fieldName));
                $sheet->getStyleByColumnAndRow($columnIndex, $rowIndex)->getFont()->setBold(true);
                $columnIndex++;
            }
        }
        break; // Stop after fetching field names
    }

    // Output data
    $rowIndex++;
    $result->data_seek(0); // Reset the result pointer to fetch data again
    while ($row = $result->fetch_assoc()) {
        $columnIndex = 1;
        foreach ($fields as $fieldName) {
            if ($fieldName === 'members') {
                $memberNameQuery = "SELECT fname, lname FROM members WHERE id='" . $row[$fieldName] . "'";
                $memberResult = $db->query($memberNameQuery);
                $member = $memberResult->fetch_assoc();
                if ($member) {
                    $memberName = $member['fname'] . ' ' . $member['lname'];
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $memberName);
                }
            } else {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $row[$fieldName]);
            }
            $columnIndex++;
        }
        $rowIndex++;
    }
} else {
    echo "0 results";
}

// Close database connection
$db->close();

// Auto-size columns for better readability
foreach (range('A', $sheet->getHighestDataColumn()) as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Create a writer object
$writer = new Xlsx($spreadsheet);

$timestamp = date('Y-m-d_H-i-s');
$filename = "Report_$timestamp.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Write the file to the browser
$writer->save('php://output');
?>
