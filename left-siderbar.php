<?php
//session_start();
include_once 'config.php';
$role_id = $_SESSION['role_id']; 
$getRole = mysqli_query($conn, "SELECT `title` FROM `tbl_user_role` WHERE `id` = $role_id");
$role = mysqli_fetch_assoc($getRole);
$userInfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `first_name`, `last_name` FROM `users` WHERE `user_id` = '".$_SESSION['user_id']."'"));
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="home.php" class="brand-link">
		<img src="img/newdlogo.png" alt="Aims-Media logo" class="brand-image img-circle elevation-3"
		style="opacity: .8">
		<span class="brand-text font-weight-light">AIMS Media</span>
	</a>
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="img/profile.jpg" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<?php if($role['title'] == 'Staff') { ?>
					<a href="staff_profile.php?id=<?php echo base64_encode($_SESSION['email']); ?>&req=<?php echo base64_encode('Sidebar');?>&caller=<?php echo base64_encode($_SERVER['PHP_SELF']);?>" class="d-block">Welcome<br> <span class="text-warning"><b><?php echo $userInfo['first_name']." ".$userInfo['last_name']; ?></b></span></a>
				<?php } else if($role['title'] == 'Associate') { 
					$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `institution_name` FROM `tbl_associate_detail` WHERE `enrollment_no` = '".$_SESSION['email']."'"));
					?>

					<a href="associate_profile.php?id=<?php echo base64_encode($_SESSION['email']); ?>&req=<?php echo base64_encode('Sidebar');?>&caller=<?php echo base64_encode($_SERVER['PHP_SELF']);?>" class="d-block">Welcome<br> <span class="text-warning"><b><?php echo $data['institution_name']; ?></b></span></a>
				<?php } else if($role['title'] == 'Student') { 
					if($_SESSION['project'] != 'AEMP'){
						?>
						<a href="stoc_student_profile.php?id=<?php echo base64_encode($_SESSION['email']); ?>&req=<?php echo base64_encode('Sidebar');?>&caller=<?php echo base64_encode($_SERVER['PHP_SELF']);?>" class="d-block">Welcome<br> <span class="text-warning"><b><?php echo $userInfo['first_name']." ".$userInfo['last_name']; ?></b></span></a>
						<?php		
					} else {
						?>
						<a href="student_profile.php?id=<?php echo base64_encode($_SESSION['email']); ?>&req=<?php echo base64_encode('Sidebar');?>&caller=<?php echo base64_encode($_SERVER['PHP_SELF']);?>" class="d-block">Welcome<br> <span class="text-warning"><b><?php echo $userInfo['first_name']." ".$userInfo['last_name']; ?></b></span></a>
					<?php  	} 
				} else { 
					?>
					<a href="#" class="d-block">Welcome<br> <span class="text-warning"><b><?php echo strtoupper($userInfo['first_name'])." ".$userInfo['last_name']; ?></b></span></a>
				<?php } ?>
			</div>
		</div>
		<nav class="mt-2 animated fadeIn">
			<ul class="nav nav-pills nav-sidebar flex-column"  data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item has-treeview menu-open">
					<a href="home.php" class="nav-link active">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>  
					</a>
				</li>
				<li class="nav-item has-treeview"> <?php if ($role['title']=='Admin' || $role['title']=='Staff') { ?> <a href="#" class="nav-link"> <i class="nav-icon fas fa-check"></i> <p>Assessments <i class="right fas fa-angle-left"></i> </p> <?php } ?> </a>
					<ul class="nav nav-treeview">
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i> Aemp CQ
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="aemp_upload_wroksheet.php" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Upload Worksheet</p>
									</a>
								</li>
								<?php if ($role['title']=='Admin'){ ?>
									<li class="nav-item">
										<a href="cq_report.php" class="nav-link">
											<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> CQ Report</p>
										</a>
									</li>
								<?php } ?>
							</ul>
						</li>
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"></i> Art & Design</p>                
							</a>
							<ul class="nav nav-treeview">
								<?php if ($role['title']=='Admin' || $role['title']=='Associate '){ ?>
									<li class="nav-item">
										<a href="#" class="nav-link">
											<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Prerequisite</p>
										</a>
									</li>
								<?php } ?>
							</ul>
						</li>
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"></i> JCQT</p>                
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="#" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Download CQ Form</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Upload CQ Exercise</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Download CQ Report</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Upload Interpretation</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Generate Report</p>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<?php 
				if ($role['title']=='Admin' || $role['title']=='Staff') {
					?>
					<li class="nav-item has-treeview">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-handshake"></i>
							<p>
								AP/LC
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item has-treeview">
								<a href="associative_search.php" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;AEMP</p>
								</a>	
							</li>
							<li class="nav-item has-treeview">
								<a href="stoc_batches.php" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;LC Registration</p>
								</a>	
							</li>
						</ul>
					</li>

				<?php }  if ($role['title']=='Admin' || $role['title']=='Staff' || $role['title']=='Associate') { ?>

					<li class="nav-item has-treeview">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-graduation-cap"></i>
							<p>
								Students
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item has-treeview">
								<a href="student_search.php" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;AEMP</p>
								</a>	
							</li>
							<?php if ($role['title']=='Admin' || $role['title']=='Staff') { ?>
								<li class="nav-item has-treeview">
									<a href="stoc_students.php" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;STOC</p>
									</a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-desktop"></i>
						<p>
							Evaluations & Monitoring
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>   
					<ul class="nav nav-treeview">
						<?php  if ($role['title'] == 'Admin' || $role['title'] == 'Staff' || $role['title'] == 'Associate' || $role['title'] == 'Student' && $_SESSION['project'] == 'AEMP') {					
							?>

							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;AEMP</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">

										<!-- Setting up AEMP for Staff -->

										<?php
										$flag1 = 0;
										$flag2 = 0;
										$flag3 = 0;
										$flag4 = 0;
										$flag5 = 0;

										?>


										<?php if ($role['title'] == 'Staff') {  
											$getProgram = mysqli_query($conn, "SELECT `program_name` FROM `tbl_associate_detail` WHERE `status` = 'Active' AND `multi_edu_email` = '".$_SESSION['email']."' GROUP BY `program_name`");

											$indiProgram = mysqli_query($conn, "SELECT `course_detail` FROM `tbl_student_detail` WHERE `user_type` = 'individual' AND `institute` IN (SELECT `st_id` FROM `tbl_staff_details` WHERE `st_email` = '".$_SESSION['email']."') ");

											while($program = mysqli_fetch_assoc($getProgram)){
												if ($program['program_name'] == 'Learning Based AEMP') {
													$flag1 = 1;
												} else if ($program['program_name'] == 'Project Based AEMP' || $program['program_name'] == 'One year diploma in graphics and editing' || $program['program_name'] == 'Workstation' || $program['program_name'] == 'Others') {
													if ($program['program_name'] == 'Project Based AEMP' || $program['program_name'] == 'One year diploma in graphics and editing'){
														$flag5 = 1;		
													}
													$flag2 = 1;
												} else if ($program['program_name'] == 'Project Based AEMP' || $program['program_name'] == 'One year diploma in graphics and editing' || $program['program_name'] == 'Workstation') {
													$flag3 = 1;
												} else if ($program['program_name'] == 'Art Discovery') {
													$flag4 = 1;
												}
											}  

											while($prog = mysqli_fetch_assoc($indiProgram)){
												if ($prog['course_detail'] == 'Learning Based AEMP') {
													$flag1 = 1;
												} else if ($prog['course_detail'] == 'Project Based AEMP' || $prog['course_detail'] == 'One year diploma in graphics and editing' || $prog['course_detail'] == 'Workstation' || $prog['course_detail'] == 'Others') {
													if ($prog['course_detail'] == 'Project Based AEMP' || $prog['course_detail'] == 'One year diploma in graphics and editing'){
														$flag5 = 1;		
													}
													$flag2 = 1;
												} else if ($prog['course_detail'] == 'Project Based AEMP' || $prog['course_detail'] == 'One year diploma in graphics and editing' || $prog['course_detail'] == 'Workstation') {
													$flag3 = 1;
												} else if ($prog['course_detail'] == 'Art Discovery') {
													$flag4 = 1;
												}
											}

											?>
											<a href="aemp_evolution.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Attendance</p>
											</a>
											<a href="aemp_pts.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Parent Training Session</p>
											</a>
											<?php if($flag1 == 1){  ?>
												<a href="aemp_eca.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> ECA</p>
												</a>
												<a href="trimester.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Trimester</p>
												</a>
											<?php }  if($flag5 == 1){  ?>
												<a href="aemp_viva.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Viva</p>
												</a>
											<?php } if($flag4 == 1){ ?>
												<a href="aemp_cgpa.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> CGPA</p>
												</a>
												<a href="semester.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Semester</p>
												</a>
											<?php } if($flag2 == 1){ ?> 
												<a href="aemp_assignment_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Assignment</p>
												</a>
											<?php } if($flag5 == 1){ ?>                  
												<a href="aemp_portfolio.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Portfolio</p>
												</a>
												<?php  
											}
											?>  
											<a href="aemp_paid_project_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Paid Project</p>
											</a>   
											<a href="aemp_monthly_report.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Monthly Report</p>
											</a>
											<a href="aemp_quarterly_report.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Quarterly Report</p>
											</a>

											<!-- Setting up AEMP for Associate -->  
										<?php } else if ($role['title'] == 'Associate'){  
											$getProgram = mysqli_query($conn, "SELECT `program_name` FROM `tbl_associate_detail` WHERE `enrollment_no` = '".$_SESSION['email']."' GROUP BY `program_name` ");
											while($program = mysqli_fetch_assoc($getProgram)){
												if ($program['program_name'] == 'Learning Based AEMP') {
													$flag1 = 1;
												} else if ($program['program_name'] == 'Project Based AEMP' || $program['program_name'] == 'One year diploma in graphics and editing' || $program['program_name'] == 'Workstation' || $program['program_name'] == 'Others') {
													if ($program['program_name'] == 'Project Based AEMP' || $program['program_name'] == 'One year diploma in graphics and editing'){
														$flag5 = 1;		
													}
													$flag2 = 1;
												} else if ($program['program_name'] == 'Project Based AEMP' || $program['program_name'] == 'One year diploma in graphics and editing' || $program['program_name'] == 'Workstation') {
													$flag3 = 1;
												} else if ($program['program_name'] == 'Art Discovery') {
													$flag4 = 1;
												}
											}                

											?>
											<a href="view_attendance.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Attendance</p>
											</a>
											<a href="aemp_pts_associate.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Parent Training Session</p>
											</a>

											<?php if($flag1 == 1){ ?>

												<a href="aemp_eca_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> ECA</p>
												</a>
												<a href="trimester.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Trimester</p>
												</a>

											<?php } if($flag5 == 1){ ?>

												<a href="aemp_viva_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Viva</p>
												</a>

											<?php } if($flag4 == 1){ ?>

												<a href="aemp_cgpa_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> CGPA</p>
												</a>
												<a href="semester.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Semester</p>
												</a>

											<?php } if($flag2 == 1){ ?> 
												<a href="aemp_assignment_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Assignment</p>
												</a>
												<?php if($flag5 == 1){ ?>                  
													<a href="aemp_portfolio.php" class="nav-link">
														<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Portfolio</p>
													</a>
												<?php }  
											}
											?>   
											<a href="aemp_paid_project_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Paid Project</p>
											</a>   
											<a href="monthly_report_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Monthly Report</p>
											</a>

											<a href="aemp_quarterly_report.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Quarterly Report</p>
											</a>


											<!-- Setting up AEMP for Student -->               
										<?php }  else if ($role['title'] == 'Student'){ 

											$getProgram = mysqli_query($conn, "SELECT `course_detail` FROM `tbl_student_detail` WHERE `enrollment_no` = '".$_SESSION['email']."'");
											while($program = mysqli_fetch_assoc($getProgram)){
												if ($program['course_detail'] == 'Learning Based AEMP') {
													$flag1 = 1;
												} else if ($program['course_detail'] == 'Project Based AEMP' || $program['course_detail'] == 'One year diploma in graphics and editing' || $program['course_detail'] == 'Workstation' || $program['course_detail'] == 'Others') {
													if ($program['course_detail'] == 'Project Based AEMP' || $program['course_detail'] == 'One year diploma in graphics and editing'){
														$flag5 = 1;		
													}
													$flag2 = 1;
												} else if ($program['course_detail'] == 'Project Based AEMP' || $program['course_detail'] == 'One year diploma in graphics and editing' || $program['course_detail'] == 'Workstation') {
													$flag3 = 1;
												} else if ($program['course_detail'] == 'Art Discovery') {
													$flag4 = 1;
												}
											}	
											?>
											<a href="view_attendance.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Attendance</p>
											</a>
											<a href="aemp_pts_parent.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Parent Training Session</p>
											</a>
											<?php if($flag1 == 1){ ?>

												<a href="aemp_eca_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> ECA</p>
												</a>

												<a href="trimester.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Trimester</p>
												</a>

											<?php } if($flag5 == 1){ ?>

												<a href="aemp_viva_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Viva</p>
												</a>

											<?php } if($flag4 == 1){ ?>

												<a href="aemp_cgpa_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> CGPA</p>
												</a>
												<a href="semester.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Semester</p>
												</a>

											<?php } if($flag2 == 1){ ?> 
												<a href="aemp_assignment_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Assignment</p>
												</a>
											<?php } if($flag5 == 1){ ?>                  
												<a href="aemp_portfolio.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Portfolio</p>
												</a>
											<?php } ?>
											<a href="aemp_paid_project_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Paid Project</p>
											</a>   
											<a href="monthly_report_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Monthly Report</p>
											</a>
											<a href="aemp_quarterly_report.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Quarterly Report</p>
											</a>

											<!-- Setting up AEMP for Admin -->
										<?php } else if ($role['title'] == 'Admin'){ ?>
											<a href="view_attendance.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Attendance</p>
											</a>
											<a href="pts_view_student.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i>  Parent Training Session</p>
											</a>
											<a href="aemp_eca_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> ECA</p>
											</a>
											<a href="aemp_viva_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Viva</p>
											</a>
											<a href="aemp_cgpa_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> CGPA</p>
											</a>
											<a href="aemp_assignment.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Assignment</p>
											</a>
											<a href="aemp_portfolio.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Portfolio</p>
											</a>
											<a href="trimester_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Trimester</p>
											</a>
											<a href="semester_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Semester</p>
											</a>
											<a href="aemp_paid_project.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Paid Project</p>
											</a>
											<a href="monthly_report_view.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Monthly Report</p>
											</a>
											<a href="aemp_quarterly_report.php" class="nav-link">
												<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Quarterly Report</p>
											</a>
										<?php } ?>
									</li>
								</ul>
							</li>
							<?php
						}
						// 	}
						// } 
						?>
						<?php 	if ($role['title']!='Associate' || $role['title'] == 'Student' && $_SESSION['project'] == 'STOC') {
							$allowed = "Yes";

									// Checking Whether the staff is associated with STOC project or not
							if($role['title']=='Staff'){
								$rows = mysqli_num_rows(mysqli_query($conn, "SELECT `id` FROM `tbl_stoc_batch_detail` WHERE `educator_id` IN (SELECT `st_id` FROM `tbl_staff_details` WHERE `st_email` = '".$_SESSION['email']."' )"));

								if($rows < 1){
									$allowed = "NO";										
								} else{
									$allowed = "Yes";
								}
							} 
							if($allowed == "Yes"){
								?>
								<li class="nav-item has-treeview">
									<a href="javascript:void(0)" class="nav-link">
										<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;STOC</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<?php 
											if ($role['title']=='Staff') { 
												?>
												<a href="stoc_attendance.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Attendance</p>
												</a>
											<?php } else if ($role['title']=='Admin' || $role['title']=='Student') { ?>
												<a href="stoc_attendance_view.php" class="nav-link">
													<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i> Attendance</p>
												</a>
											<?php } ?>
										</li>
									</ul>
								</li>
								<?php 
							}
						}
						?>

						<?php   if($role['title'] == 'Admin'){ ?>
							<li class="nav-item">
								<a href="javascript:void(0)" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;JCQT</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="#" class="nav-link">
											<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i></p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="javascript:void(0)" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;ARTOLOGY</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="#" class="nav-link">
											<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i></p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="javascript:void(0)" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;ART and Design</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="#" class="nav-link">
											<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i></p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="javascript:void(0)" class="nav-link">
									<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;Home-Schooling-Certificate</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="#" class="nav-link">
											<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-sign"></i></p>
										</a>
									</li>
								</ul>
							</li>
							<?php    ?>
						<?php } ?>
					</ul>
				</li>


  <!-- <li class="nav-item has-treeview">

    <a href="#" class="nav-link">

      <i class="nav-icon fas fa-check"></i>

      <p>

        Attendance Guidelines

        <i class="right fas fa-angle-left"></i>

      </p>

    </a>

    <ul class="nav nav-treeview">

      <li class="nav-item">

        <a href="registration.php" class="nav-link">

          <i class="far fa-circle nav-icon"></i>

          <p>Start and end session time option in each class</p>

        </a>

      </li>

      <li class="nav-item">

       <a href="associative_search.php" class="nav-link">

        <i class="far fa-circle nav-icon"></i>

        <p>Mention topic code</p>

      </a>

    </li>

  </ul>

</li> -->




<?php 

if ($role['title']=='Admin' || $role['title']=='Staff' || $role['title']=='Associate' || $role['title']=='Student' ) {
	?>
	<li class="nav-item has-treeview">
		<a href="#" class="nav-link">
			<i class="nav-icon fas fa-upload"></i>
			<p>
				Uploads   
				<i class="fas fa-angle-left right"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item has-treeview">
				<a href="javascript:void(0)" class="nav-link">
					<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;AEMP</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php if($role['title']=='Admin' || $role['title']=='Staff'){ echo 'program_curriculum.php'; }elseif($role['title']=='Associate' || $role['title']=='Student'){ echo 'program_curriculum_view.php'; } ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Program Curriculum</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php if($role['title']=='Admin' || $role['title']=='Staff'){ echo 'teaching_learning_material.php'; }elseif($role['title']=='Associate' || $role['title']=='Student'){ echo 'teaching_learning_view.php'; } ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Teaching Learning Material</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="homework.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Homework</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="previous_summery.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Previous Summery</p>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="nav nav-treeview">
			<li class="nav-item has-treeview">
				<a href="javascript:void(0)" class="nav-link">
					<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;STOC</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="stoc_program_curriculum.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Program Curriculum</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="stoc_teaching_learning.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Teaching Learning Material</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="stoc_homework.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Homework</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="stoc_previous_summery.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Previous Summery</p>
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>
<?php } ?>
<?php 

if ($role['title']!=='Staff' ) {


	?>
	<li class="nav-item has-treeview">
		<a href="#" class="nav-link">
			<i class="nav-icon fa fa-sun-o"></i>
			<p>
				Certification   
				<i class="fas fa-angle-left right"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="certificate_progressive_report.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>AEMP</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="stoc_certificate_progressive.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>STOC</p>
				</a>
			</li>
		</ul>
	</li>

<?php } ?>
<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
		<i class="fas fa-broadcast-tower"></i>
		<p>&nbsp; Communication<i class="fas fa-angle-left right"></i></p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item has-treeview">
			<a href="student_search.php" class="nav-link">
				<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;AEMP</p>
			</a>	
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="notice.php" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Notice</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="communication_feedback.php" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Feedback</p>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item has-treeview">
			<a href="javascript:void(0)" class="nav-link">
				<p> &nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"> </i>&nbsp;&nbsp;&nbsp;STOC</p>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="stoc_notice" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Notice</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="stoc_feedback.php" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Feedback</p>
					</a>
				</li>
			</ul>
		</li>
	</ul>
</li>

<?php if($role['title'] == 'Admin'){ ?>
	<li class="nav-item has-treeview">
		<a href="news_media_detail.php" class="nav-link">
			<i class="fas fa-newspaper-o"></i>
			<p>&nbsp; News & Media<i class="fas fa-angle-left right"></i>
			</p>
		</a>
	</li>


<?php } ?>

<li class="nav-item has-treeview">
	<a href="news_event.php" class="nav-link">
		<i class="fas fa-bullhorn"></i>
		<p>&nbsp; Announcements<i class="fas fa-angle-left right"></i></p>
	</a>
</li>


<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
		<i class="nav-icon fas fa-users"></i>
		<p>
			Human Resources    
			<i class="fas fa-angle-left right"></i>
		</p>
	</a>

	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="staff_details.php" class="nav-link">
				<i class="far fa-circle nav-icon"></i>
				<p>Profile</p>
			</a>
		</li>
		<?php if($role['title']=='Staff') { ?>
			<li class="nav-item">
				<a href="apply_leave.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>Apply Leave</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="staff-drs-detail.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>DRS</p>
				</a>
			</li>
		<?php  } if($role['title']=='Admin' || $role['title']=='Staff') { ?>
			<li class="nav-item">
				<a href="hr_documents.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>HR Documents</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="staff-request-detail.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>Request</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="reimbursement.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>Reimbursements</p>
				</a>
			</li>
			<?php if($role['title']=='Admin'){ ?>
				<li class="nav-item">
					<a href="monthly-staff-drs-detail.php" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>DRS</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="leave_requests.php" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Leave Requests</p>
					</a>
				</li>
			<?php  } 
		}
		?>
	</ul>
</li>
<?php if($role['title']=='Admin') { ?>
	<li class="nav-item has-treeview">
		<a href="add_inventory.php" class="nav-link">
			<i class="nav-icon far fa fa-houzz"></i>
			<p>
				Inventory
				<i class="fas fa-angle-left right"></i>
			</p>
		</a>
	</li>
<?php } ?>
<li class="nav-item has-treeview">
	<?php if($role['title']=='Admin' || $role['title']=='Associate ') { ?>

		<a href="#" class="nav-link">
			<i class="nav-icon far fa fa-user-plus"></i>
			<p>
				Accounts
				<i class="fas fa-angle-left right"></i>
			</p>
		</a>
	<?php } ?>

	<ul class="nav nav-treeview">

		<?php if($role['title']=='Admin') { ?>

			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>User Details</p>
				</a>
			</li>
		<?php } ?>

		<?php if($role['title']=='Admin' || $role['title']=='Associate ') { ?>

			<li class="nav-item">

				<a href="#" class="nav-link">

					<i class="far fa-circle nav-icon"></i>

					<p>Invoice</p>

				</a>

			</li>

			<li class="nav-item">

				<a href="#" class="nav-link">

					<i class="far fa-circle nav-icon"></i>

					<p>Payment Gateway</p>

				</a>

			</li>

			<li class="nav-item">

				<a href="#" class="nav-link">

					<i class="far fa-circle nav-icon"></i>

					<p>Outstanding Blance</p>

				</a>

			</li>



			<li class="nav-item">

				<a href="#" class="nav-link">

					<i class="far fa-circle nav-icon"></i>

					<p>Due Payments</p>

				</a>

			</li>

			<?php 

		}

		?>

		<li class="nav-item">

			<a href="#" class="nav-link">

				<i class="far fa-circle nav-icon"></i>

				<p>Receipts</p>

			</a>

		</li>



		<li class="nav-item">

			<a href="#" class="nav-link">

				<i class="far fa-circle nav-icon"></i>

				<p>Study Material/Consignment Receipts</p>

			</a>

		</li>   

	</ul>

</li>


<?php if ($role['title']=='Admin') { ?>
	<li class="nav-item has-treeview">
		<a href="javascript:void(0)" class="nav-link">
			<i class="nav-icon fas fa-file"></i>
			<p>
				Database
				<i class="fas fa-angle-left right"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="report.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>Reports</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="newsletter.php" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>Newsletter</p>
				</a>
			</li>
		</ul>
	</li>
<?php } ?>



<li class="nav-item has-treeview">

	<a href="index.php" class="nav-link">

		<i class="nav-icon fa fa-sign-out"></i>

		<p>

			Logout

		</p>

	</a>

</li>



</ul>

</nav>

<!-- /.sidebar-menu -->

</div>

<!-- /.sidebar -->

</aside>