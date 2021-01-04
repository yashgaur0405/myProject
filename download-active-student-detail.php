<?php
session_start();
error_reporting(0);
include("include/config.php");
$cinstitute = base64_decode($_GET['institute']);
$cprogramval = base64_decode($_GET['program']);
/* vars for export */
$csv_filename = 'active_student_data_'.date('Y-m-d').'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csv_filename);
$fp = fopen('php://output', 'w');
if (!isset($_GET['stoc'])) {

	fputcsv($fp, array('#','Type', 'Institution/Staff', 'Applicant Name','Guardian Name','Enrollment No','Program','dob','difficulty_disability','disability_certificate','gender','nationality','parent_salutation','guardian_name','occupation','parmanent_address','correspondent_address','telephone_no','mobile_no','emergency_contact_no','family_disability','aemp_mode','duration','joining_date','other_course_detail','insert_date'));
	$c=1;
	$sql ="SELECT * FROM `tbl_student_detail` WHERE status='Existing Student'";
	if($cinstitute!="")
		$sql=$sql." "."and institute='$cinstitute'";
	if($cprogramval!="")
		$sql=$sql." "."and course_detail='$cprogramval'";
	$sql=$sql." "."order by institute ASC";
	$query_assoc = mysqli_query($conn,$sql);
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
			fputcsv($fp, array($c++,$user_type,$ass_detail,$applicant_name,$guardian_name,$enrollment_no,$course_detail,$dob,$difficulty_disability,$disability_certificate,$gender,$nationality,$parent_salutation,$guardian_name,$occupation,$parmanent_address,$correspondent_address,$telephone_no,$mobile_no,$emergency_contact_no,$family_disability,$aemp_mode,$duration,$joining_date,$other_course_detail,$insert_date));
		}
	}
}elseif (isset($_GET['stoc'])) {
	fputcsv($fp, array('#', 'Staff Name', 'Applicant Name','Guardian Name','Enrollment No','Program','DOB','Difficulty Disability','Disability Type','Gender','Occupation','Parmanent Address','Email','Mobile_no','Create date','Status','Complete Date'));
	$c=1;
	$sql ="SELECT * FROM `tbl_stoc_students` WHERE status='Existing' ORDER BY applicant_name";

	$query_assoc = mysqli_query($conn,$sql);
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