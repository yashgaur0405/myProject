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

          $query_assoc = mysqli_query($conn,"SELECT * FROM `tbl_stoc_batch_detail` WHERE status='Existing'");

          ?>
          <div class="card w-100"style="box-shadow:5px 2px 2px;">
            <div class="card-body  w-100">

              <div class="portlet-body" style="overflow-x: auto;">
                <div class="tab-content" style="margin-top: -5px;padding: 0.5rem 1rem;">
                  <div id="tab_1_1" class="tab-pane show active" style="height:250px; overflow-Y:scroll;">
                    <table id="datatable1" class="table table-responsive table-sm table-bordered table-hover" style="display: inline-table;" >
                      <thead>
                       <tr>
                        <th><b>#</b></th>
                        <th><b>Program Name</b></th>
                        <th><b>Batch No</b></th>
                        <th><b>Status</b></th>
                        <th><b>Remark</b></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php
                     $c=1;
                     if(mysqli_num_rows($query_assoc)>0)
                     {    
                      while($row=mysqli_fetch_assoc($query_assoc))
                      {           
                       ?>
                       <tr>
                        <td><?php echo $c;?></td>
                        <td><?php echo $row['program_name'];?></td>
                        <td><?php echo $row['batch_no'];?></td>
                        <td><?php echo $row['status'];?></td>
                        <td><?php echo $row['remarks'];?></td>

                      </tr>
                      
                    <?php $c++;} }
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
              <a href="download-active-associate-partner-detail.php?stoc&location=<?php echo base64_encode($clocation); ?>&program=<?php echo base64_encode($cproductval); ?>&product=<?php echo base64_encode($cprogramval); ?>" class="btn btn-primary"><i class="fa fa-download"></i> &nbsp; &nbsp; Download</a><br clear="all"><br>
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
