<?php
include("connection.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$name_member_id=$_GET['name_member_id'];
// echo $name_member_id;
// exit;

$start_date=$_POST['start_date1'];
$end_date=$_POST['end_date1'];


$clientname=$_POST['clientname'];
if(empty($clientname)){
$sql = "SELECT 
id, 
clientname, 
job, 
members, 
notes, 
completion, 
time_comp, 
reference, 
entry_date, 
assigned_by, 
job_status, 
close_time, 
cus_date 
FROM 
jobcreate 
WHERE 
job_status = 'Closed Completed' 
AND completion >= '$start_date' 
AND completion < '$end_date' 
AND members = '$name_member_id'"; 
}
else{
    $sql = "SELECT 
id, 
clientname, 
job, 
members, 
notes, 
completion, 
time_comp, 
reference, 
entry_date, 
assigned_by, 
job_status, 
close_time, 
cus_date 
FROM 
jobcreate 
WHERE 
job_status = 'Closed Completed' 
AND completion >= '$start_date' 
AND completion < '$end_date' 
AND members = '$name_member_id' AND clientname='$clientname'"; 

}

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
