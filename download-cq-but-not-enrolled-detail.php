<?php
ob_start();
error_reporting(0);
include("include/config.php");
$cdate1 = base64_decode($_GET['sdate']);
$cdate2 = base64_decode($_GET['edate']);
/* vars for export */
$csv_filename = 'CQ_But_Not_Enrolled_data_'.date('Y-m-d').'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csv_filename);
$fp = fopen('php://output', 'w');
if (!isset($_GET['stoc'])) {

	fputcsv($fp, array('#','user_type', 'institute_individual_name', 'associate_name','associate_email','associate_phone','associate_address','no_of_associate_student','Insert Date','','','student_name','guardian_name','student_contact','student_dob','email-id','address','disability','disability_detail','insert_date'));
	$c=1;
	$res11 = mysqli_query($conn,"select * from tbl_aemp_detail where insert_date>='$cdate1' and insert_date<='$cdate2' ");
	while($fetch_product1=mysqli_fetch_array($res11))
	{
		extract($fetch_product1);
		if($user_type=="Individual" && is_null($enroll_detail)) { 
			fputcsv($fp, array($c++,$user_type,$institute_individual_name,'','','','','',$insert_date,'','',$associate_name,$institute_individual_name,$user_phone,$student_dob,$user_email,$address,$disability,$disability_detail,$insert_date));
		}
		else
		{
			$res12 = mysqli_query($conn,"select * from tbl_aemp_student_detail where aemp_user_id='$user_id' and enroll_detail is null");
			if(mysqli_num_rows($res12)>0)
			{
				fputcsv($fp, array($c++,$user_type,$institute_individual_name,$associate_name,$user_email,$user_phone,$address,$no_of_student,$insert_date));
				while($fetch_product11=mysqli_fetch_array($res12))
				{
					fputcsv($fp, array('','','','','','','','','','','',$fetch_product11['student_name'],$fetch_product11['guardian_name'],$fetch_product11['student_contact'],$fetch_product11['student_dob'],$fetch_product11['email_id'],$fetch_product11['address'],$fetch_product11['student_disability'],$fetch_product11['student_disability_detail'],$fetch_product11['	insert_date']));
				}
			}
		}
	}
}elseif(isset($_GET['stoc'])){
	fputcsv($fp, array('#','User Name', 'Gender', 'Phone','Email','DOB','Guardian Name','Address','City','Diability','Disabilty Info','Occupation','Institute','insert_date'));
	$c=1;
	$res11 = mysqli_query($conn,"SELECT * from tbl_online_course where insert_date>='$cdate1' and insert_date<='$cdate2' AND enrolled != 'Yes' ");
	while($fetch_product1=mysqli_fetch_array($res11))
	{
		extract($fetch_product1);
		
		fputcsv($fp, array($c++,$user_name,$gender,$user_phone,$user_email,$user_dob,$parentname,$address,$city,$disabled,$disabilityinfo,$occupation,$insname,$insert_date));
	}
			
}
exit;
?>