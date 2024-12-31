<?php
include("connection.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$export_assigned = $_POST['export_assigned'];

$current_date = date('Y-m-d');
$sql = "SELECT @row := @row + 1 AS serial_no, id, clientname, job, members, notes, completion, assigned_by 
        FROM (SELECT @row := 0) r, jobcreate 
        WHERE completion = '$current_date' AND members='$export_assigned'";
// $sql = "SELECT 
//             @row := CASE WHEN @prevMember != members THEN 1 ELSE @row + 1 END AS serial_no,
//             @prevMember := members AS members,
//             id, 
//             clientname, 
//             job, 
//             notes, 
//             completion, 
//             assigned_by 
//         FROM 
//             (SELECT @row := 0, @prevMember := NULL) r, 
//             (SELECT * FROM jobcreate WHERE completion = '$current_date' ORDER BY members) jobcreate";



$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Output field names as bold and uppercase
    $columnIndex = 1;
    $rowIndex = 1;
    $fields = []; // Initialize fields array
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
    $serialNo = 1; // Initialize serial number
    $result->data_seek(0); // Reset the result pointer to fetch data again
    while ($row = $result->fetch_assoc()) {
        $columnIndex = 1;
        $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $serialNo); // Add serial_no value
        $serialNo++; // Increment serial number for each row
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
