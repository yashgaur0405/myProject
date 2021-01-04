<?php 
session_start();
if (!isset($_SESSION['email'])) { header('location:index.php'); }
include_once 'include/config.php';
$role_id = $_SESSION['role_id']; 
$getRole = mysqli_query($conn, "SELECT `title` FROM `tbl_user_role` WHERE `id` = $role_id");
$role = mysqli_fetch_assoc($getRole);
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>Aims-Media | Existing Student Detail</title>
	<!-- Tell the browser to be responsive to screen width -->
	<link href="{{ asset('theme/plugins/select2/css/select2.css')}}" rel="stylesheet"/>
	<?php include'include/top-script.php' ?>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> -->

</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<!-- Header -->
		<?php include 'include/header.php' ?>
		<?php include 'include/left-siderbar.php' ?>
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row form-group mb-2">
						<div class="col-sm-8">
							<h1>Existing Student Detail</h1>
						</div>
						<div class="col-md-4">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="report.php" class="btn btn-info"><i class="fas fa-arrow-left"></i> Back</a></li>
							</ol>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<?php
						if(isset($_SESSION['error'])){
							echo "
							<div class='alert alert-danger alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
										<h4><i class='icon fa fa-warning'></i> Error!</h4>
										".$_SESSION['error']."
										</div>
										";
										unset($_SESSION['error']);
						} else if(isset($_SESSION['success'])){
						echo "
						<div class='alert alert-success alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
										<h4><i class='icon fa fa-check'></i> Success!</h4>
										".$_SESSION['success']."
										</div>
										";
										unset($_SESSION['success']);
						}
						?>
						<div class="col-lg-12 col-md-12 col-sm-12">
						<?php 
		
							$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_stoc_students` WHERE status='Existing' order by applicant_name asc");
		
						?>
						<div class="card w-100"style="box-shadow:5px 2px 2px;">
							<div class="card-body  w-100">
									<div class="portlet-body" style="overflow-x: auto;">
										<div class="tab-content" style="margin-top: -5px;padding: 0.5rem 1rem;padding-bottom:0; margin-bottom:0.2%; height:300px; overflow-Y:scroll; overflow-X:hidden;">
											<div id="tab_1_1" class="tab-pane show active">
												<table id="datatable1" class="table table-responsive table-sm table-bordered table-hover text-center" style="display: inline-table;" >
													<thead>
														<tr>
															<th style="font-size:14px;color:#131212;"><b>#</b></th>
															<th style="font-size:14px;color:#131212;"><b>Applicant Name</b></th>
															<th style="font-size:14px;color:#131212;"><b>Guardian Name</b></th>
															<th style="font-size:14px;color:#131212;"><b>Enrollment No</b></th>
															<th style="font-size:14px;color:#131212;"><b>Program</b></th>
														</tr>
													</thead>
													<tbody id="myTableNew" class="tbody">
														<?php
														
														if (mysqli_num_rows($query_assoc) == 0) {
															?>
															<tr><td colspan="6">No data available</td></tr>
															<?php
														} else {
															$i=1;
															while($row = mysqli_fetch_assoc($query_assoc)) { 
																?>
																<tr>
																	<td style="font-size:14px;"><?php echo $i;?></td>
																	<td style="font-size:14px;"><?php echo $row['applicant_name'];?></td>
																	<td style="font-size:14px;"><?php echo $row['guardian_name'];?></td>
																	<td style="font-size:14px;"><?php echo $row['enrollment_no'];?></td>
																	<td style="font-size:14px;"><?php echo $row['course_detail'];?></td>
																</tr>
																<?php 
																$i++;
															}
														}
														?>
													</tbody> 
												</table>	
											</div>
										</div>
									</div>
									 <div class="col-lg-12" style="padding-bottom:2%;padding-top:1%;">
									  <a href="download-active-student-detail.php?stoc&institute=<?php echo base64_encode($cinstitute); ?>&program=<?php echo base64_encode($cprogramval); ?>" class="btn btn-primary"><i class="fa fa-download"></i> &nbsp; &nbsp; Download</a><br clear="all"><br>
									  </div>
								</div>
							</div>
						</div>
				</section>
			</div>
			<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
			<?php include 'include/footer-script.php' ?>
			<script>
				$('.number').keyup(function(e)
				{
					if (/\D/g.test(this.value))
					{
						this.value = this.value.replace(/\D/g, '');
					}
				});
			</script>
			<script>
				$(document).ready(function () {
					$("select").select2();
				});
			</script>
		</body>
		</html>

