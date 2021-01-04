<?php
session_start();
error_reporting(0);
include("include/config.php");
/* vars for export */
$csv_filename = 'complete_terminate_student_data_'.date('Y-m-d').'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csv_filename);
$fp = fopen('php://output', 'w');
if (!isset($_GET['stoc'])) {

	fputcsv($fp, array('#','Type', 'Institution/Staff', 'Applicant Name','Guardian Name','Enrollment No','Program','DOB','Difficulty Disability','Disability Certificate','Gender','Nationality','Occupation','Parmanent Address','correspondent address','Email','Mobile_no','Emergency Contact_no','aemp mode','joining date','duration','other_course_detail','remark','Status','Complete Date'));
	$c=1;
	$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_student_detail` WHERE status!='Existing Student'");
	if (mysqli_num_rows($query_assoc) > 0) {
		while($row=mysqli_fetch_array($query_assoc))
		{
			extract($row);
			$ass_detail='';
			if($row['user_type']=="institutional") {
				$ass_id=$row['institute'];
				$query_ins = mysqli_query($conn,"SELECT * FROM tbl_associate_detail where associate_id='$ass_id'");
				$row_data = mysqli_fetch_assoc($query_ins);
				$ass_detail=$row_data['institution_name'];
			}else{
				$ass_id=$row['institute'];
				$query_ins = mysqli_query($conn,"SELECT * FROM tbl_staff_details where st_id='$ass_id'");
				$row_data = mysqli_fetch_assoc($query_ins);
				$ass_detail=$row_data['st_name'];
			}
			fputcsv($fp, array($c++,$user_type,$ass_detail,$applicant_name,$guardian_name,$enrollment_no,$course_detail,$dob,$difficulty_disability,$disability_certificate,$gender,$nationality,$occupation,$parmanent_address,$correspondent_address,$email,$mobile_no,$emergency_contact_no,$aemp_mode,$joining_date,$duration,$other_course_detail,$remark,$status,$modification_datetime));
		}
	}
}elseif (isset($_GET['stoc'])) {
	fputcsv($fp, array('#', 'Staff Name', 'Applicant Name','Guardian Name','Enrollment No','Program','DOB','Difficulty Disability','Disability Type','Gender','Occupation','Parmanent Address','Email','Mobile_no','Create date','Status','Complete Date'));

	$c=1;
	$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_stoc_students` WHERE status!='Existing' ORDER BY applicant_name");
	if (mysqli_num_rows($query_assoc) > 0) {
		while($row=mysqli_fetch_array($query_assoc))
		{
			extract($row);
			$get_staff_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT st_name FROM tbl_staff_details WHERE st_id IN(SELECT educator_id FROM tbl_stoc_batch_detail WHERE id = '$course_batch_id' )"));
			extract($get_staff_name);
			fputcsv($fp, array($c++,$st_name,$applicant_name,$guardian_name,$enrollment_no,$course_detail,$dob,$disability,$disability_type,$gender,$occupation,$address,$email,$mobile,$insert_date,$status,$modification_dateTime));
		}
	}
}
exit;
?>