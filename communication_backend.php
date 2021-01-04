<?php  
	session_start();
	require_once 'include/config.php';
?>
<?php

	$output = array();
if (isset($_POST['type']) && $_POST['type'] == "get_individual") {
		$indi_value = $_POST['indi_value'];
		$get_course = mysqli_query($conn, "SELECT * FROM tbl_student_detail WHERE user_type = '$indi_value' AND status = 'Existing Student' GROUP BY course_detail");
		if ($get_course) {
			while($get_name = mysqli_fetch_assoc($get_course)){
				$output[] = $get_name;
			}
			echo json_encode($output);
		}else{
			die("Error:".mysqli_query($conn));
		}		
		
	}

	if (isset($_POST['type']) && $_POST['type'] == "get_institute_course") {
		$indi_value = $_POST['indi_value'];
		$get_course = mysqli_query($conn, "SELECT * FROM tbl_associate_detail WHERE institution_name = '$indi_value' AND status = 'Active'");
		if ($get_course) {
			while($get_name = mysqli_fetch_assoc($get_course)){
				$output[] = $get_name;
			}
			echo json_encode($output);
		}else{
			die("Error:".mysqli_query($conn));
		}
	}

	/*------------------------------------FOR STOC----------------------------------*/

	if (isset($_POST['type']) AND $_POST['type'] == 'stoc_get_course') {
		
		$batch = $_POST['batch_value'];
		$get_course = mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_stoc_batch_detail WHERE id = '$batch' AND status = 'Existing' ");
		$option = '<option value="" selected hidden>Select Course</option>';
		while ($data = mysqli_fetch_assoc($get_course)) {
			$option .= '<option>'.$data['program_name'].'</option>';
		}
		echo $option;
	}

?>