<?php 
session_start();

if (!isset($_SESSION['email'])) {
  header('location:index.php');
}
  include_once 'include/config.php';

$role_id = $_SESSION['role_id']; 
$getRole = mysqli_query($conn, "SELECT `title` FROM `tbl_user_role` WHERE `id` = $role_id");
$role = mysqli_fetch_assoc($getRole);
if($role['title']=='Admin' || $role['title']=='Staff' || $role['title']=='Student' || $role['title']=='Associate')
{
             // header('location:home.php');
}
            //echo "<pre>";echo $_SESSION['role'];die;
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aims-Media | AEMP DETAILS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <link href="{{ asset('theme/plugins/select2/css/select2.css')}}" rel="stylesheet"/>
  <?php include'include/top-script.php' ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
  <?php include 'include/header.php' ?>
  <?php include 'include/left-siderbar.php'?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-md-6">
            <h1>Inactive Previous Summary</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        
        <div class="col-lg-12 col-md-12 col-sm-12">
          <?php 
		  date_default_timezone_set('Asia/Calcutta');
		  $cdate1  = date("Y-m-d");
		  $cdate2  = date("Y-m-d");
		  if(isset($_REQUEST['subset']))
		  {
			$cdate1=$_POST['searchdate1'];
			$cdate2=$_POST['searchdate2'];
		  }
		  ?>
          <div class="card w-100"style="box-shadow:5px 2px 2px;">
            <div class="card-body  w-100">
              <div class="row ml-2">
                <form class="w-100" name="form1" method="post" action="" novalidate="novalidate">
                  <div class="form-group row">
                    <div class="col-md-4">
                      <label for="exampleInputEmail1">From Date</label>
                      <input type="date" class="input-sm form-control" value="<?php echo $cdate1; ?>" required name="searchdate1">
                    </div>
                    <div class="col-md-4">
                      <label for="exampleInputEmail1">To Date</label>
                      <input type="date" class="input-sm form-control" value="<?php echo $cdate2; ?>" required name="searchdate2">
                    </div>
                    <div class="col-md-3" style="margin-top: 35px;">
                      <button class="btn btn-sm btn-default" name="subset" type="submit">Go!</button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="portlet-body" style="overflow-x: auto;">
                <div class="tab-content" style="margin-top: -5px;padding: 0.5rem 1rem;">
                  <div id="tab_1_1" class="tab-pane show active">
                    <table id="datatable1" class="table table-responsive table-sm table-bordered table-hover" style="display: inline-table;" >
                      <thead>
                       <tr>
						<th>#</th>
						  <th>Type</th>
						  <th>Student Name</th>
						  <th>Enrollment No</th>
						  <th>Title</th>
						  <th>Program</th>
						  <th>Inserted By</th>
						  <th>Insert Date</th>
						</tr>
                      </thead>
                     <tbody>
                     <?php
                     $c=1;
                    $res = mysqli_query($conn,"SELECT * from tbl_stoc_upload where status='inactive' AND type = 'Previous Summary' and update_date>='$cdate1' and update_date<='$cdate2'");
                    if(mysqli_num_rows($res)>0)
                    {    
						while($getList = mysqli_fetch_assoc($res))
						{ 
							$get_enroll_name = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE email = '".$getList['inserted_id']."' ");
							$get_name = mysqli_fetch_assoc($get_enroll_name);
							$get_student = mysqli_query($conn, "SELECT applicant_name,enrollment_no FROM tbl_stoc_students WHERE student_id = '".$getList['student_id']."' ");
							$get_stu_name = mysqli_fetch_assoc($get_student);          
					?>
					<tr>
						<td><?php echo $c++; ?></td>
						<td><?php echo $getList['type']; ?></td>
						<td><?php echo $get_stu_name['applicant_name']; ?></td>
						<td><?php echo $get_stu_name['enrollment_no']; ?></td>
						<td><?php echo $getList['title']; ?></td>
						<td><?php echo $getList['program_name']; ?></td>
						<td><?php echo $get_name['first_name'].' '.$get_name['last_name']; ?></td>
						<td><?php echo $getList['inserted_date']; ?></td>
                    </tr>
					<?php } }
					else 
                    { ?>
					<tr><td colspan='9'>No Data Available</td></tr>
					<?php } ?>
				</tbody>
			</table>
    </div>
  </div>
</div>
</div>
            <div class="col-lg-12" style="padding-bottom:2%;padding-top:1%;">
  <a href="download-inactive-previous-summary.php?stoc&sdate=<?php echo base64_encode($cdate1); ?>&edate=<?php echo base64_encode($cdate2); ?>" class="btn btn-primary"><i class="fa fa-download"></i> &nbsp; &nbsp; Download</a><br clear="all"><br>
  </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</div>
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
