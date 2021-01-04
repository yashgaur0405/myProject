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
            <h1>Pre-Requisites</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-head">
            
          </div>
          <div class="card-body">
            
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

    $(document).ready(function () {
        $("select").select2();
    });
</script>
</body>
</html>
