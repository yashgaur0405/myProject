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
  <title>Aims-Media | Active  Associative Partners</title>
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
          <div class="col-md-8">
            <h1>Active  Associative Partners Details </h1>
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
        }
        if(isset($_SESSION['success'])){
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
		if(isset($_REQUEST['subset']))
		{
			$clocation=$_POST['location'];
			$cproductval=$_POST['productval'];
			$cprogramval=$_POST['programval'];
			$sql ="SELECT * FROM `tbl_associate_detail` WHERE status='Active'";
			if($clocation!="")
				$sql=$sql." "."and institution_address='$clocation'";
			if($cproductval!="")
				$sql=$sql." "."and product_name='$cproductval'";
			if($cprogramval!="")
				$sql=$sql." "."and program_name='$cprogramval'";
			$sql=$sql." "."order by associate_name ASC";
			$query_assoc = mysqli_query($conn,$sql);
		}
		else
		{
			$query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_associate_detail` WHERE status='Active' order by associate_name asc");
		}
		?>
          <div class="card w-100"style="box-shadow:5px 2px 2px;">
            <div class="card-body  w-100">
              <div class="row ml-2">
                <form class="w-100" name="form1" method="post" action="" novalidate="novalidate">
                  <div class="form-group row">
                    <div class="col-md-3">
                      <label for="exampleInputEmail1">Location</label>
                      <select class="form-control" name="location" required>
					   <option value="" selected>Select Location</option>
                        <?php 
						$qry_check = mysqli_query($conn, "SELECT distinct institution_address FROM tbl_associate_detail WHERE status='Active'");
                        while ($res = mysqli_fetch_assoc($qry_check))
                        {
                          ?>
							<option value="<?php echo $res['institution_address']; ?>" <?php if($clocation==$res['institution_address']) { echo "selected"; } ?>><?php echo $res['institution_address']; ?>
							</option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="exampleInputEmail1">Product</label>
                      <select class="form-control" name="productval">
					   <option value="" selected>Select Product</option>
                        <?php 
						$qry_check = mysqli_query($conn, "SELECT distinct product_name FROM tbl_associate_detail WHERE status='Active'");
                        while ($res = mysqli_fetch_assoc($qry_check))
                        {
                          ?>
                          <option value="<?php echo $res['product_name']; ?>" <?php if($cproductval==$res['product_name']) { echo "selected"; } ?>><?php echo $res['product_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
					 <div class="col-md-3">
                      <label for="exampleInputEmail1">Program</label>
                      <select class="form-control" name="programval">
					   <option value="" selected>Select Program</option>
                        <?php 
						$qry_check = mysqli_query($conn, "SELECT distinct program_name FROM tbl_associate_detail WHERE status='Active'");
                        while ($res = mysqli_fetch_assoc($qry_check))
                        {
                          ?>
                          <option value="<?php echo $res['program_name']; ?>" <?php if($cprogramval==$res['program_name']) { echo "selected"; } ?>><?php echo $res['program_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-3" style="margin-top: 35px;">
                      <button class="btn btn-sm btn-default" name="subset" type="submit">Go!</button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="portlet-body" style="overflow-x: auto;">
                <div class="tab-content" style="margin-top: -5px;padding: 0.5rem 1rem;">
                  <div id="tab_1_1" class="tab-pane show active" style="height:250px; overflow-Y:scroll;">
                    <table id="datatable1" class="table table-responsive table-sm table-bordered table-hover" style="display: inline-table;" >
                      <thead>
						<tr>
							<th class="all" style="font-size:14px;color:#131212;"><b>#</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Institution Name</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Associate Name</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Mobile</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Email</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Location</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Product</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Program</b></th>
							<th class="all" style="font-size:14px;color:#131212;"><b>Status</b></th>
						</tr>
                      </thead>
                     <tbody>
                     <?php
                     $c=1;
                    if(mysqli_num_rows($query_assoc)>0)
                    {    
						while($fetch_product2=mysqli_fetch_assoc($query_assoc))
						{           
					?>
                    <tr>
                      <td title="S.No." style="font-size:14px;"><?php echo $c++; ?></td>
                      <td style="font-size:14px;"><?php echo $fetch_product2['institution_name']; ?></td>
                      <td style="font-size:14px;"><?php echo $fetch_product2['associate_name']; ?></td>
                      <td style="font-size:14px;"><?php echo $fetch_product2['associate_contact']; ?></td>
                      <td style="font-size:14px;"><?php echo $fetch_product2['associate_email']; ?></td>
                      <td style="font-size:14px;"><?php echo $fetch_product2['institution_address']; ?></td>
                      <td style="font-size:14px;"><?php echo $fetch_product2['product_name']; ?></td> 
					  <td style="font-size:14px;"><?php echo $fetch_product2['program_name']; ?></td> 
					  <td style="font-size:14px;"><?php echo $fetch_product2['status']; ?></td> 
                    </tr>
                  <?php } }
                   else 
                    { ?>
                  <tr><td colspan='8'>No Data Available</td></tr>
                  <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


	<div class="col-lg-12" style="padding-bottom:2%;padding-top:1%;">
		<a href="download-active-associate-partner-detail.php?location=<?php echo base64_encode($clocation); ?>&program=<?php echo base64_encode($cproductval); ?>&product=<?php echo base64_encode($cprogramval); ?>" class="btn btn-primary"><i class="fa fa-download"></i> &nbsp; &nbsp; Download</a><br clear="all"><br>
	</div>

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
