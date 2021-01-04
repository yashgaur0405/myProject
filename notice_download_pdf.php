<?php

ob_start();
error_reporting(0);

require_once 'include/config.php';

$cdate1 = base64_decode($_GET['from']);
$cdate2 = base64_decode($_GET['to']);
$type = base64_decode($_GET['type']);
$login = base64_decode($_GET['log']);

if (!isset($_GET['stoc'])) {

	$csv_filename = 'notice_sheet_'.date('Y-m-d').'.csv';
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename='.$csv_filename);
	$fp = fopen('php://output', 'w');

	if ($type == 'Admin') {
		
		fputcsv($fp, array('#', 'Message', 'Staff Name', 'Program', 'Date'));
		$count = 1;
		$get_data = mysqli_query($conn, "SELECT * FROM communication_notice WHERE created_at >= '$cdate1' AND created_at <= '$cdate2' ");
		while ($data = mysqli_fetch_assoc($get_data)) {
			$staff_id = $data['staff_id'];
			$get_data_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '$staff_id'"));
			fputcsv($fp, array($count, $data['message'], $get_data_name['first_name'].' '.$get_data_name['last_name'], $data['program'], $data['created_at']));
			$count++;
		}

	}
	elseif ($type == 'Associate') {

		fputcsv($fp, array('#', 'Message', 'Staff Name', 'Program', 'Date'));
		$get_data = mysqli_query($conn, "SELECT * FROM communication_notice WHERE created_at >= '$cdate1' AND created_at <= '$cdate2' AND institute IN (SELECT associate_id FROM tbl_associate_detail WHERE enrollment_no = '$login')");

		$count = 1;
		while ($data = mysqli_fetch_assoc($get_data)) {
			$staff_id = $data['staff_id'];
			$get_data_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '$staff_id'"));
			fputcsv($fp, array($count, $data['message'], $get_data_name['first_name'].' '.$get_data_name['last_name'], $data['program'], $data['created_at']));
			$count++;
		}
	}
	elseif ($type == 'Staff') {
		$get_data = mysqli_query($conn, "SELECT * FROM communication_notice WHERE staff_id='$login' AND created_at >= '$cdate1' AND created_at <= '$cdate2' ");
		fputcsv($fp, array('#', 'Message', 'Program', 'Date'));
		$count = 1;
		while ($data = mysqli_fetch_assoc($get_data)) {
			$staff_id = $data['staff_id'];
			$get_data_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '$staff_id'"));
			fputcsv($fp, array($count, $data['message'], $data['program'], $data['created_at']));
			$count++;
		}
		
	}

}else{
	$csv_filename = 'notice_sheet_'.date('Y-m-d').'.csv';
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename='.$csv_filename);
	$fp = fopen('php://output', 'w');

	if ($type == 'Admin') {
		fputcsv($fp, array('#', 'Message', 'Staff Name', 'Program', 'Date'));
		$count = 1;
		$get_data = mysqli_query($conn, "SELECT * FROM stoc_communication_notice WHERE created_at >= '$cdate1' AND created_at <= '$cdate2' ");
		while ($data = mysqli_fetch_assoc($get_data)) {
			$staff_id = $data['staff_id'];
            $get_data_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '$staff_id'"));
			fputcsv($fp, array($count, $data['message'], $get_data_name['first_name'].' '.$get_data_name['last_name'], $data['program'], $data['created_at']));
			$count++;
		}
	}elseif ($type == 'Staff') {
		
		fputcsv($fp, array('#', 'Message', 'Program', 'Date'));
		$count = 1;
		$get_data = mysqli_query($conn, "SELECT * FROM stoc_communication_notice WHERE staff_id='$login' AND created_at >= '$cdate1' AND created_at <= '$cdate2' ");	
		while ($data = mysqli_fetch_assoc($get_data)) {			
			fputcsv($fp, array($count, $data['message'], $data['program'], $data['created_at']));
			$count++;
		}

	}	
}


exit;		

?>



