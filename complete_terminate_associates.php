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
	<title>Aims-Media | Completed and Terminated Associative Partners</title>
	<!-- Tell the browser to be responsive to screen width -->
	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
		/* Firefox */
		input[type=number] {
			-moz-appearance: textfield;
		}
		.select2-container{
			width:100% !important;
		}
		.card label {
			border-left: 2px solid #413fff;
			padding-left: 10px;
			background: -webkit-linear-gradient(left,#f2faff,#ffffff00);
			padding: 6px;
			font-family: sans-serif;
			font-weight: bold;
			color: #413fff;
		}
		#none{
			display:block;
		}
		table td{
			word-break: break-word !important;
		}
		.text-wrap{
			white-space:normal;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="../include/DataTables/datatables.css">
	<link rel="stylesheet" type="text/css" href="../include/DataTables/datatables.min.css">
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
							<h1>Completed and Terminated Associative Partners</h1>
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
					<div class="card w-100"style="box-shadow:5px 2px 2px;">
						<div class="card-body  w-100"> 
							<div class="row form-group  ml-2">
								<div class="col-md-12">
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
									<div class="row form-group">
										<div class="col-md-12 mb-2 float-right">
											<input type="text" id="myInputNew" onkeyup="myFunction()" placeholder="Search ..." title="Type in a name" style="width: 300px" class="form-control pull-right">
										</div>
									</div>
									<div class="portlet-body" style="overflow-x: auto;">
										<div class="tab-content" style="margin-top: -5px;padding: 0.5rem 1rem;">
											<div id="tab_1_1" class="tab-pane show active">
												<table id="datatable1" class="table table-responsive table-sm table-bordered table-hover text-center" style="display: inline-table;" >
													<thead>
														<tr>
															<th><b>#</b></th>
															<th><b>Institution Name</b></th>
															<th><b>Associate Name</b></th>
															<th><b>Mobile</b></th>
															<th><b>Email</b></th>
															<th><b>Location</b></th>
															<th><b>Product</b></th>
															<th><b>Status</b></th>
															<th><b>Remark</b></th>
															<th><b>Action</b></th>
														</tr>
													</thead>
													<tbody id="myTableNew" class="tbody">
														<?php
														$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_associate_detail` WHERE `status` IN ('Complete', 'Terminate')");
														if (mysqli_num_rows($query_assoc) == 0) {
															?>
															<tr><td colspan="9">No data available</td></tr>
															<?php
														} else {
															$i=1;
															while($row = mysqli_fetch_assoc($query_assoc)) { 
																?>
																<tr>
																	<td><?php echo $i;?></td>
																	<td><?php echo $row['institution_name'];?></td>
																	<td><?php echo $row['associate_name'];?></td>
																	<td><?php echo $row['associate_contact'];?></td>
																	<td><?php echo $row['associate_email'];?></td>
																	<td><?php echo $row['institution_address'];?></td>
																	<td><?php echo $row['product_name'];?></td>
																	<td><?php echo $row['status'];?></td>
																	<td><?php echo $row['remarks'];?></td>
																	<td width="70">

																		<a class="btn btn-sm btn-outline-success" href="associative_view.php?id=<?php echo base64_encode($row['associate_id']);?>" title="Click to view complete partner info"><i class="fa fa-eye"></i></a>
																	</td>
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
									  <a href="download-complete-terminate-associate-detail.php" class="btn btn-primary"><i class="fa fa-download"></i> &nbsp; &nbsp; Download</a><br clear="all"><br>
									  </div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
			<?php include 'include/footer-script.php' ?>
			<script src="../include/DataTables/datatables.js"></script>
			<script type="text/javascript">
				$('#datatable1').dataTable({ sDom: 'lrtip',bLengthChange: false });
			</script>

			<script>
				$(document).ready(function(){
					$("#myInputNew").on("keyup", function() {
						var value = $(this).val().toLowerCase();
						$("#myTableNew tr").filter(function() {
							$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
						});
					});
				});
			</script>
			<!-- <script>
				$(document).ready(function() {
					$('table').DataTables();
				});
			</script> -->
		</body>
		</html>

