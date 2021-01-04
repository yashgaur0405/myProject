<?php 
session_start();
if (!isset($_SESSION['email'])) {
	header('location:index.php');
}

include_once 'include/config.php';
include_once 'include/slugify.php';

$role_id = $_SESSION['role_id']; 
$getRole = mysqli_query($conn, "SELECT `title` FROM `tbl_user_role` WHERE `id` = $role_id");
$role = mysqli_fetch_assoc($getRole);
if($role['title']=='Admin' || $role['title']=='Staff' || $role['title']=='Student' || $role['title']=='Associate')
{
             // header('location:home.php');
}
$login = $_SESSION['email'];
?>

<!DOCTYPE HTML>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Aims-Media | AEMP-DETAIL</title>
	<!-- Tell the browser to be responsive to screen width -->
	<?php include'include/top-script.php' ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<!-- header -->
		<?php include 'include/header.php' ?>
		<!-- left-siderbar -->
		<?php include 'include/left-siderbar.php' ?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">  
						<div class="col-sm-6">
							<h1>AEMP Detail</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="homw.php">Home</a></li>
							</ol>
						</div>
					</div>
				</div>
			</section>
			<!------Add visitior from------>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">

							<div class="card card-primary card-outline">
								<div class="card-header" style="text-align:center;">
									<input type="button" class="btn btn-info" class="btn btn-xs btn-outline-info" value="AEMP Program Detail" name="request_submit" style="font-size:15px;padding:3px 15px;">
								</div>
								<div class="card-body pad table-responsive">
									<table class="table table-hovered table-bordered table-responsive" style="font-size: small">
										<tbody>
											<tr>
												<?php if($role['title'] != 'Student' AND $role['title'] != 'Associate'){ ?>
													<td width='20%' style="text-align:center;"><a class="btn btn-warning" style="font-size:15px;padding:3px 15px;">Assessment</a></td>
												<?php } ?>
												<?php if($role['title'] == 'Admin'){ ?>
													<td width='15%' style="text-align:center;"><a href="associative_search.php" style="font-size:15px;padding:3px 15px;" class="btn btn-primary">Associate</a></td>
												<?php } ?>
												<?php if($role['title'] != 'Student'){ ?>
													<td width='15%' style="text-align:center;"><a href="student_search.php" style="font-size:15px;padding:3px 15px;" class="btn btn-danger">Student</a></td>
												<?php } ?>
												<td width='30%' style="text-align:center;"><a style="font-size:15px;padding:3px 15px;" class="btn btn-success">Evaluation & Monitoring</a></td>
												<td width='20%' style="text-align:center;"><a style="font-size:15px;padding:3px 15px;" class="btn btn-sm bg-maroon">Uploads</a></td>
												<td width='20%' style="text-align:center;"><a style="font-size:15px;padding:3px 15px;" class="btn btn-sm bg-warning">Communication</a></td>
												<?php if($role['title'] != 'Staff'){ ?>
													<td width='20%' style="text-align:center;"><a href="certificate_progressive_report.php" style="font-size:15px;padding:3px 15px;" class="btn btn-sm bg-secondary">Certificate</a></td>
												<?php } ?>
											</tr>
											<?php  if($role['title'] == 'Admin'){ ?>
												<tr>
													<td>
														<a href="aemp_upload_wroksheet.php"><i class="fa fa-dot-circle-o"></i> Upload Worksheet</a><hr>
														<a href="cq_report.php"><i class="fa fa-dot-circle-o"></i> CQ Report</a><hr>
													</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>
														<a href="view_attendance.php"><i class="fa fa-dot-circle-o"></i> Attendance</a><hr>
														<a href="pts_view_student.php"><i class="fa fa-dot-circle-o"></i> Parents training session</a><hr>
														<a href="aemp_eca_view.php"><i class="fa fa-dot-circle-o"></i> ECA</a><hr>
														<a href="aemp_viva_view.php"><i class="fa fa-dot-circle-o"></i> VIVA</a><hr>
														<a href="aemp_cgpa_view.php"><i class="fa fa-dot-circle-o"></i> CGPA</a><hr>
														<a href="aemp_assignment.php"><i class="fa fa-dot-circle-o"></i> Assignment</a><hr>
														<a href="aemp_portfolio.php"><i class="fa fa-dot-circle-o"></i> Portfolio</a><hr>
														<a href="trimester_view.php"><i class="fa fa-dot-circle-o"></i> Trimester</a><hr>
														<a href="semester_view.php"><i class="fa fa-dot-circle-o"></i> Semester</a><hr>
														<a href="monthly_report_view.php"><i class="fa fa-dot-circle-o"></i> Monthly Report</a><hr>
														<a href="aemp_quarterly_report.php"><i class="fa fa-dot-circle-o"></i> Quarter report</a>

													</td>
													<td>
														<a href="program_curriculum.php"><i class="fa fa-dot-circle-o"></i> Program curriculum </a><hr>
														<a href="teaching_learning_material.php"><i class="fa fa-dot-circle-o"></i> Teaching Learning Material </a><hr>
														<a href="homework.php"><i class="fa fa-dot-circle-o"></i> Homework</a><hr>
														<a href="previous_summery.php"><i class="fa fa-dot-circle-o"></i> Previous Summary</a><hr>
													</td>
													<td>
														<a href="news_event.php"><i class="fa fa-dot-circle-o"></i> Annoucements</a><hr>
														<a href="notice.php"><i class="fa fa-dot-circle-o"></i> Notice</a><hr>
														<a href="communication_feedback.php"><i class="fa fa-dot-circle-o"></i> Feedback</a><hr>
													</td>
													<td>&nbsp;</td>
												</tr>
											<?php }elseif ($role['title'] == 'Staff') { ?>
												<tr>
													<td>
														<a href="aemp_upload_wroksheet.php"><i class="fa fa-dot-circle-o"></i> Upload Worksheet</a><hr>
													</td>
													<td>&nbsp;</td>

													<td>
														<a href="aemp_evolution.php"><i class="fa fa-dot-circle-o"></i> Attendance</a><hr>
														<a href="aemp_pts.php"><i class="fa fa-dot-circle-o"></i> Parents training session</a><hr>
														<?php 
														$check_eca = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE multi_edu_email = '$login' AND program_name = 'Learning Based AEMP' AND status = 'Active' "));
														$check_eca_individual = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE user_type = 'individual' AND institute IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active') AND course_detail = 'Learning Based AEMP' AND status = 'Existing Student' ")); 
														if(($check_eca + $check_eca_individual) > 0)
														{
															?>
															<a href="aemp_eca.php"><i class="fa fa-dot-circle-o"></i> ECA</a><hr>
														<?php } 
														$check_viva = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE multi_edu_email = '$login' AND program_name IN ('Project Based AEMP', 'One year diploma in graphics and editing') AND status = 'Active' "));
														$check_viva_individual = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE user_type = 'individual' AND institute IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active') AND course_detail IN ('Project Based AEMP', 'One year diploma in graphics and editing') AND status = 'Existing Student' ")); 
														if(($check_viva + $check_viva_individual) > 0)
															{
																?>
																<a href="aemp_viva.php"><i class="fa fa-dot-circle-o"></i> VIVA</a><hr>
																<?php  
															}
															$check_cgpa_institution = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE multi_edu_email = '$login' AND program_name = 'Art Discovery' AND status = 'Active' "));
															$check_cgpa_individual = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE user_type = 'individual' AND institute IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active') AND course_detail = 'Art Discovery' AND status = 'Existing Student' "));
															if (($check_cgpa_institution + $check_cgpa_individual) > 0) { ?>
																<a href="aemp_cgpa.php"><i class="fa fa-dot-circle-o"></i> CGPA</a><hr>
															<?php } 
															$check_assignment = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE multi_edu_email = '$login' AND program_name IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation', 'Others') AND status = 'Active' "));
															$check_assignment_individual = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE user_type = 'individual' AND institute IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active') AND course_detail IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation', 'Others') AND status = 'Existing Student' "));
															if (($check_assignment + $check_assignment_individual) > 0) {
																?>              
																<a href="aemp_assignment_view.php"><i class="fa fa-dot-circle-o"></i> Assignment</a><hr>
															<?php }
															$check_portfolio = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE multi_edu_email = '$login' AND program_name IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation', 'Others') AND status = 'Active' "));
															$check_portfolio_individual = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE user_type = 'individual' AND institute IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active') AND course_detail IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation', 'Others') AND status = 'Existing Student' "));
															if (($check_portfolio + $check_portfolio_individual) > 0) {
																?>
																<a href="aemp_portfolio.php"><i class="fa fa-dot-circle-o"></i> Portfolio</a><hr>
																<?php  
															}
															$check_trimester_institute = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE multi_edu_email = '$login' AND program_name = 'Learning Based AEMP' AND status = 'Active' "));
															$check_trimester_individual = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE user_type = 'individual' AND institute IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active') AND course_detail = 'Learning Based AEMP' AND status = 'Existing Student' "));
															$check_semester_institute = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE multi_edu_email = '$login' AND program_name = 'Art Discovery' AND status = 'Active' "));
															$check_semester_individual = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE user_type = 'individual' AND institute IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active') AND course_detail = 'Art Discovery' AND status = 'Existing Student' "));
															$trimester = $check_trimester_institute + $check_trimester_individual;
															$semester = $check_semester_institute + $check_semester_individual;
															if ($trimester > 0) { ?>
																<a href="trimester.php"><i class="fa fa-dot-circle-o"></i> Trimester</a><hr>
															<?php }
															 if ($semester > 0) { ?>
																<a href="semester.php"><i class="fa fa-dot-circle-o"></i> Semester</a><hr>
															<?php }  ?>
															<a href="aemp_paid_project_view.php"><i class="fa fa-dot-circle-o"></i> Paid Project</a><hr>
															<a href="aemp_monthly_report.php"><i class="fa fa-dot-circle-o"></i> Monthly Report</a><hr>
															<a href="aemp_quarterly_report.php"><i class="fa fa-dot-circle-o"></i> Quarter report</a>

														</td>
														<td>
															<a href="program_curriculum.php"><i class="fa fa-dot-circle-o"></i> Program curriculum </a><hr>
															<a href="teaching_learning_material.php"><i class="fa fa-dot-circle-o"></i> Teaching Learning Material </a><hr>
															<a href="homework.php"><i class="fa fa-dot-circle-o"></i> Homework</a><hr>
															<a href="previous_summery.php"><i class="fa fa-dot-circle-o"></i> Previous Summary</a><hr>
														</td>
														<td>
															<a href="news_event.php"><i class="fa fa-dot-circle-o"></i> Annoucements</a><hr>
															<a href="notice.php"><i class="fa fa-dot-circle-o"></i> Notice</a><hr>
															<a href="communication_feedback.php"><i class="fa fa-dot-circle-o"></i> Feedback</a><hr>
														</td>

													</tr>
												<?php }elseif ($role['title'] == 'Associate') { ?>
													<tr>
														<td>&nbsp;</td>
														<td>
															<a href="view_attendance.php"><i class="fa fa-dot-circle-o"></i> Attendance</a><hr>
															<a href="aemp_pts_associate.php"><i class="fa fa-dot-circle-o"></i> Parents training session</a><hr>

															<?php  
															$check_cgpa = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name = 'Art Discovery' AND status = 'Active' "));
															if($check_cgpa > 0){
																?>
																<a href="aemp_cgpa.php"><i class="fa fa-dot-circle-o"></i> CGPA</a><hr>
															<?php }
															$check_assignment = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation', 'Others') AND status = 'Active' ")); 
															if($check_assignment > 0){
																?>
																<a href="aemp_assignment_view.php"><i class="fa fa-dot-circle-o"></i> Assignment</a><hr>
															<?php }
															$check_portfoilo = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation') AND status = 'Active' ")); 
															if($check_portfoilo > 0){
																?>
																<a href="aemp_portfolio.php"><i class="fa fa-dot-circle-o"></i> Portfolio</a><hr>
															<?php }
															$check_eca = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name = 'Learning Based AEMP' AND status = 'Active' ")); 
															if($check_eca > 0){
																?>
																<a href="aemp_eca.php"><i class="fa fa-dot-circle-o"></i> ECA</a><hr>
															<?php } 
															$check_viva = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name IN ('Project Based AEMP', 'One year diploma in graphics and editing') AND status = 'Active' ")); 
															if ($check_viva > 0) {
																?>
																<a href="aemp_viva.php"><i class="fa fa-dot-circle-o"></i> VIVA</a><hr>
															<?php }
															$check_trimester = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name = 'Learning Based AEMP' AND status = 'Active' "));
															$check_semester = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name = 'Art Discovery' AND status = 'Active' "));
															if ($check_trimester > 0) { ?>
																<a href="trimester.php"><i class="fa fa-dot-circle-o"></i> Trimester</a><hr>
															<?php }
															if ($check_semester > 0) { ?>
																<a href="semester.php"><i class="fa fa-dot-circle-o"></i> Semester</a><hr>
															<?php } ?>
															<a href="aemp_paid_project_view.php"><i class="fa fa-dot-circle-o"></i> Paid Project</a><hr>
															<a href="monthly_report_view.php"><i class="fa fa-dot-circle-o"></i> Monthly Report</a><hr>
															<a href="aemp_quarterly_report.php"><i class="fa fa-dot-circle-o"></i> Quarter report</a>

														</td>
														<td>
															<a href="program_curriculum_view.php"><i class="fa fa-dot-circle-o"></i> Program curriculum </a><hr>
															<a href="teaching_learning_view.php"><i class="fa fa-dot-circle-o"></i> Teaching Learning Material </a><hr>
															<a href="homework.php"><i class="fa fa-dot-circle-o"></i> Homework</a><hr>
															<a href="previous_summery.php"><i class="fa fa-dot-circle-o"></i> Previous Summary</a><hr>          
														</td>
														<td>
															<a href="news_event.php"><i class="fa fa-dot-circle-o"></i> Annoucements</a><hr>
															<a href="notice.php"><i class="fa fa-dot-circle-o"></i> Notice</a><hr>
															<a href="communication_feedback.php"><i class="fa fa-dot-circle-o"></i> Feedback</a><hr>
														</td>
														<td>&nbsp;</td>
													</tr>
												<?php }elseif ($role['title'] == 'Student') { ?>
													<tr>

														<td>

															<a href="view_attendance.php"><i class="fa fa-dot-circle-o"></i> Attendance</a><hr>

															<a href="aemp_pts_parent.php"><i class="fa fa-dot-circle-o"></i> Parents training session</a><hr>

															<?php 
															$eca = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE course_detail = 'Learning Based AEMP' AND enrollment_no = '$login' AND status = 'Existing Student' "));
															if($eca > 0){
																?>
																<a href="aemp_eca.php"><i class="fa fa-dot-circle-o"></i> ECA</a><hr>

															<?php }
															$viva = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE course_detail IN ('Project Based AEMP', 'One year diploma in graphics and editing') AND enrollment_no = '$login' AND status = 'Existing Student' "));
															if($viva > 0){
																?>               
																<a href="aemp_viva.php"><i class="fa fa-dot-circle-o"></i> VIVA</a><hr>

															<?php }
															$cgpa = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE course_detail = 'Art Discovery' AND enrollment_no = '$login' AND status = 'Existing Student' "));
															if($cgpa > 0){ 
																?>
																<a href="aemp_cgpa_view.php"><i class="fa fa-dot-circle-o"></i> CGPA</a><hr>

															<?php } 
															$assignment = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE course_detail IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation') AND enrollment_no = '$login' AND status = 'Existing Student' "));
															if($assignment > 0){
																?>
																<a href="aemp_assignment_view.php"><i class="fa fa-dot-circle-o"></i> Assignment</a><hr>

															<?php }
															$portfolio = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program_name FROM tbl_associate_detail WHERE enrollment_no = '$login' AND program_name IN ('Project Based AEMP', 'One year diploma in graphics and editing', 'Workstation') AND status = 'Active' ")); 
															if($portfolio > 0){
																?>
																<a href="aemp_portfolio.php"><i class="fa fa-dot-circle-o"></i> Portfolio</a><hr>

															<?php }
															$trimester = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE course_detail = 'Learning Based AEMP' AND enrollment_no = '$login' AND status = 'Existing Student' "));
															$semester = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT course_detail FROM tbl_student_detail WHERE course_detail = 'Art Discovery' AND enrollment_no = '$login' AND status = 'Existing Student' "));
															if ($trimester > 0) { ?>
																<a href="trimester.php"><i class="fa fa-dot-circle-o"></i> Trimester</a><hr>

															<?php  }
															if ($semester > 0) { ?>
																<a href="semester.php"><i class="fa fa-dot-circle-o"></i> Semester</a><hr>

															<?php } ?>            
															<a href="aemp_paid_project_view.php"><i class="fa fa-dot-circle-o"></i> Paid Project</a><hr>
															<a href="monthly_report_view.php"><i class="fa fa-dot-circle-o"></i> Monthly Report</a><hr>
															<a href="aemp_quarterly_report.php"><i class="fa fa-dot-circle-o"></i> Quarter report</a>

														</td>
														<td>
															<a href="program_curriculum_view.php"><i class="fa fa-dot-circle-o"></i> Program curriculum </a><hr>
															<a href="teaching_learning_view.php"><i class="fa fa-dot-circle-o"></i> Teaching Learning Material </a><hr>
															<a href="homework.php"><i class="fa fa-dot-circle-o"></i> Homework</a><hr>
															<a href="previous_summery.php"><i class="fa fa-dot-circle-o"></i> Previous Summary</a><hr>
														</td>
														<td>
															<a href="news_event.php"><i class="fa fa-dot-circle-o"></i> Annoucements</a><hr>
															<a href="notice.php"><i class="fa fa-dot-circle-o"></i> Notice</a><hr>
															<a href="communication_feedback.php"><i class="fa fa-dot-circle-o"></i> Feedback</a><hr>
														</td>
														<td>&nbsp;</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>


			</div>

			<?php include 'include/footer-script.php' ?>
			<!-- notification show model -->
		</body>
		</html>
