<?php
ob_start();
error_reporting(0);
include("include/config.php");
$clocation = base64_decode($_GET['location']);
$cproductval = base64_decode($_GET['program']);
$cprogramval = base64_decode($_GET['product']);
/* vars for export */
$csv_filename = 'active_associate_detail_'.date('Y-m-d').'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csv_filename);
$fp = fopen('php://output', 'w');
if (!isset($_GET['stoc'])) {

	fputcsv($fp, array('#','institution_name', 'institution_address', 'associate_name','associate_contact','associate_email','product_name','program_name','program_duration','mou_date','batch_code','batch_commencement_date','batch_timing','	aemp_mode','batch_coordinator','batch_contact_number','batch_email_address','multimedia_educator','multimedia_educator_contact','multimedia_educator_email','institution_account_member','institution_account_number','institution_account_email','enrollment_number','branding','insert_date'));

	$c=1;
	$sql ="SELECT * FROM `tbl_associate_detail` WHERE status='Active'";
	if($clocation!="")
		$sql=$sql." "."and institution_address='$clocation'";
	if($cproductval!="")
		$sql=$sql." "."and product_name='$cproductval'";
	if($cprogramval!="")
		$sql=$sql." "."and program_name='$cprogramval'";
	$sql=$sql." "."order by associate_name ASC";
	$query_assoc = mysqli_query($conn,$sql);
	if(mysqli_num_rows($query_assoc)>0)
	{    
		while($fetch_product2=mysqli_fetch_assoc($query_assoc))
		{ 
			fputcsv($fp, array($c++,$fetch_product2['institution_name'],$fetch_product2['institution_address'],$fetch_product2['associate_name'],$fetch_product2['associate_contact'],$fetch_product2['associate_email'],$fetch_product2['product_name'],$fetch_product2['program_name'],$fetch_product2['program_duration'],$fetch_product2['mou_date'],$fetch_product2['batch_code'],$fetch_product2['batch_com_date'],$fetch_product2['batch_timing'],$fetch_product2['aemp_mode'],$fetch_product2['batch_co_name'],$fetch_product2['batch_co_contact'],$fetch_product2['batch_co_email'],$fetch_product2['multi_edu_name'],$fetch_product2['multi_edu_contact'],$fetch_product2['multi_edu_email'],$fetch_product2['inst_acc_member_name'],$fetch_product2['inst_acc_member_contact'],$fetch_product2['inst_acc_member_email'],$fetch_product2['enrollment_no'],$fetch_product2['branding'],$fetch_product2['account_creation_time']));
		}	
	}
}elseif(isset($_GET['stoc'])){
	fputcsv($fp, array('#','Program Name', 'Batch No', 'duration','Educator Name','Student Strength','Start Date','End Date','Associate Name','Status','Remark','Complete Date'));
	$c=1;
	$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_stoc_batch_detail` WHERE `status` = 'Existing' ");
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