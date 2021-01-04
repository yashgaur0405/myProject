<?php
session_start();
error_reporting(0);
include("include/config.php");
$cdate1 = base64_decode($_GET['sdate']);
$cdate2 = base64_decode($_GET['edate']);
/* vars for export */
$csv_filename = 'complete_terminate_associate_data_'.date('Y-m-d').'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csv_filename);
$fp = fopen('php://output', 'w');
if (!isset($_GET['stoc'])) {

	fputcsv($fp, array('#','Institution Name', 'Associate Name', 'Mobile','Email','Location','Product','Status','Remark','Complete Date'));
	$c=1;
	$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_associate_detail` WHERE `status` IN ('Complete', 'Terminate')");
	if (mysqli_num_rows($query_assoc) > 0) {
		while($row=mysqli_fetch_array($query_assoc))
		{
			extract($row);
			fputcsv($fp, array($c++,$institution_name,$associate_name,$associate_contact,$associate_email,$institution_address,$product_name,$status,$remarks,$last_modification_time));
		}
	}
}elseif (isset($_GET['stoc'])) {
	fputcsv($fp, array('#','Program Name', 'Batch No', 'duration','Educator Name','Student Strength','Start Date','End Date','Associate Name','Status','Remark','Complete Date'));
	$c=1;
	$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_stoc_batch_detail` WHERE `status` != 'Existing' ");
	if (mysqli_num_rows($query_assoc) > 0) {
		while($row=mysqli_fetch_array($query_assoc))
		{
			extract($row);

			$staff_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT st_name FROM tbl_staff_details WHERE st_id = '$educator_id'"));
			extract($staff_name);
			fputcsv($fp, array($c++,$program_name,$batch_no,$duration,$st_name,$student_strength,$start_date,$end_date,$associate_name,$status,$remark,$modification_dateTime));
		}
	}
}
exit;
?>