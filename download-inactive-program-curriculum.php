<?php
ob_start();
error_reporting(0);
include("include/config.php");
$cdate1 = base64_decode($_GET['sdate']);
$cdate2 = base64_decode($_GET['edate']);
/* vars for export */
$csv_filename = 'Program_Curriculum_data_'.date('Y-m-d').'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csv_filename);
$fp = fopen('php://output', 'w');
if (!isset($_GET['stoc'])) {

	fputcsv($fp, array('#','Title', 'Type','Institute/Student', 'Program','Insert By','Inserted Name','Insert Date','Txn Date'));
	$c=1;
	$res = mysqli_query($conn,"select * from program_curriculum where status='inactive' and update_date>='$cdate1' and update_date<='$cdate2'");
	if(mysqli_num_rows($res)>0)
	{    
		while($getList = mysqli_fetch_assoc($res))
		{ 
			$get_enroll_name = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE email = '".$getList['inserted_id']."' ");
			$get_name = mysqli_fetch_assoc($get_enroll_name);
			if($getList['type']=='individual')
			{
				$get_stu_name = mysqli_query($conn, "SELECT applicant_name FROM tbl_student_detail WHERE student_id = '".$getList['student_id']."' ");
				$get_stu_name = mysqli_fetch_assoc($get_stu_name); 
				$stu_ins_name=$get_stu_name['applicant_name'];
			}
			else
			{
				$get_stu_name = mysqli_query($conn, "SELECT institution_name FROM tbl_associate_detail WHERE associate_id = '".$getList['institute']."' ");
				$get_stu_name = mysqli_fetch_assoc($get_stu_name); 
				$stu_ins_name=$get_stu_name['institution_name'];
			}
			fputcsv($fp, array($c++,$getList['title'],$stu_ins_name,$getList['type'],$getList['program_name'],$getList['inserted_by'],$get_name['first_name'].' '.$get_name['last_name'],$getList['inserted_date'],$getList['update_date']));
		}
	}
}elseif (isset($_GET['stoc'])) {
	fputcsv($fp, array('#','Title', 'Student', 'Insert By','Inserted Name','Insert Date','Txn Date'));
	$c=1;
	$res = mysqli_query($conn,"SELECT * FROM tbl_stoc_upload where status='inactive' and update_date>='$cdate1' and update_date<='$cdate2'");
	if(mysqli_num_rows($res)>0)
	{    
		while($getList = mysqli_fetch_assoc($res))
		{ 
			$get_enroll_name = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE email = '".$getList['inserted_id']."' ");
			$get_name = mysqli_fetch_assoc($get_enroll_name);

				$get_stu_name = mysqli_query($conn, "SELECT applicant_name FROM tbl_stoc_students WHERE student_id = '".$getList['student_id']."' ");
				$get_stu_name = mysqli_fetch_assoc($get_stu_name); 
				$stu_ins_name=$get_stu_name['applicant_name'];
			
			fputcsv($fp, array($c++,$getList['title'],$stu_ins_name,$getList['inserted_by'],$get_name['first_name'].' '.$get_name['last_name'],$getList['inserted_date'],$getList['update_date']));
		}
	}
}
exit;
?>