<?php
ob_start();
error_reporting(0);
include("include/config.php");
$cdate1 = base64_decode($_GET['sdate']);
$cdate2 = base64_decode($_GET['edate']);
/* vars for export */
$csv_filename = 'Previous_Summary_data_'.date('Y-m-d').'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csv_filename);
$fp = fopen('php://output', 'w');
if (!isset($_GET['stoc'])) {

	fputcsv($fp, array('#','Type', 'Student Name', 'Enrollment No','Title','Program','Institute Name','Inserted By','Insert Date','Update Date'));
	$c=1;
	$res = mysqli_query($conn,"select * from previous_summary_detail where status='inactive' and update_date>='$cdate1' and update_date<='$cdate2'");
	if(mysqli_num_rows($res)>0)
	{    
		while($getList = mysqli_fetch_assoc($res))
		{ 
			$get_enroll_name = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE email = '".$getList['inserted_id']."' ");
			$get_name = mysqli_fetch_assoc($get_enroll_name);
			$get_student = mysqli_query($conn, "SELECT applicant_name,enrollment_no FROM tbl_student_detail WHERE student_id = '".$getList['student_id']."' ");
			$get_stu_name = mysqli_fetch_assoc($get_student); 
			$get_inst = mysqli_fetch_assoc(mysqli_query($conn, "SELECT institution_name FROM tbl_associate_detail WHERE associate_id = '".$getList['institute']."'"));
			fputcsv($fp, array($c++,$getList['type'],$get_stu_name['applicant_name'],$get_stu_name['enrollment_no'],$getList['title'],$getList['program_name'],$get_inst['institution_name'], $get_name['first_name'].' '.$get_name['last_name'],$getList['inserted_date'],$getList['update_date']));
		}
	}
}elseif (isset($_GET['stoc'])) {
	fputcsv($fp, array('#','Type', 'Student Name', 'Enrollment No','Title','Program','Inserted By','Insert Date','Update Date'));
	$c=1;
	$res = mysqli_query($conn,"SELECT * from tbl_stoc_upload where status='inactive' AND type = 'Previous Summary' and update_date>='$cdate1' and update_date<='$cdate2'");
	if(mysqli_num_rows($res)>0)
	{    
		while($getList = mysqli_fetch_assoc($res))
		{ 
			$get_enroll_name = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE email = '".$getList['inserted_id']."' ");
			$get_name = mysqli_fetch_assoc($get_enroll_name);
			$get_student = mysqli_query($conn, "SELECT applicant_name,enrollment_no FROM tbl_stoc_students WHERE student_id = '".$getList['student_id']."' ");
			$get_stu_name = mysqli_fetch_assoc($get_student); 
			
			fputcsv($fp, array($c++,$getList['type'],$get_stu_name['applicant_name'],$get_stu_name['enrollment_no'],$getList['title'],$getList['program_name'], $get_name['first_name'].' '.$get_name['last_name'],$getList['inserted_date'],$getList['update_date']));
		}
	}
}
exit;
?>