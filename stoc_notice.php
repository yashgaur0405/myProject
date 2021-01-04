<?php 
session_start();
if (!isset($_SESSION['email'])) {
  header('location:index.php');
}

include_once 'include/config.php';
include_once 'include/slugify.php';
include_once 'common_class.php';
$message_send = new CommonClass();
$role_id = $_SESSION['role_id']; 
$getRole = mysqli_query($conn, "SELECT `title` FROM `tbl_user_role` WHERE `id` = $role_id");
$role = mysqli_fetch_assoc($getRole);
if($role['title']=='Admin' || $role['title']=='Staff' || $role['title']=='Student' || $role['title']=='Associate')
{
             // header('location:home.php');
}
$today = date('Y-m-d');
if(isset($_POST['notice_send'])) {
  
  $login = $_SESSION['email'];
  $batch = $_POST['batch'];
  $course_name = $_POST['course'];
  $message = mysqli_escape_string($conn, $_POST['message']);    

    $insert_notice = mysqli_query($conn, "INSERT INTO stoc_communication_notice(batch, staff_id, program, message, created_at) VALUES('$batch', '$login', '$course_name', '$message', '$today')");
    if ($insert_notice) {
      echo "<script>alert('Notice SuccessFully Submitted')</script>";
      $send_message = mysqli_query($conn, "SELECT * FROM tbl_stoc_students WHERE course_batch_id = '$batch' AND course_detail = '$course_name' AND status = 'Existing'");
      while ($get = mysqli_fetch_assoc($send_message)) {
        $message_send->sendMessage($get['mobile'], $message); 
        $insert_notification = mysqli_query($conn, "INSERT INTO tbl_notification(student_id, type, sent_number, message, user_type, sent_date) VALUES('".$get['student_id']."', 'notice', '".$get['mobile']."', '$message', 'stoc', '$today')");
      }
    }else{
      die("Notice_error".mysqli_error($conn));
    }
}
?>

<!DOCTYPE HTML>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aims-Media | STOC-NOTICE </title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php include'include/top-script.php' ?>
  <style type="text/css">
    .col-md-4, .col-md-2, .col-md-10{
      margin-top: 20px;
    }
    .loader {
      margin-top: 30px;
      border: 2px solid #f3f3f3;
      border-radius: 50%;
      border-top: 1px solid blue;
      border-bottom: 1px solid blue;
      width: 20px;
      height: 20px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
  
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
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">  </a> / upload/Compose Notice</li>
              </ol>
            </div>
            <div class="col-sm-6 float-sm-right"></div>
          </div>
        </div>
      </section>
      <!------Add visitior from------>
      <?php if ($role['title']=='Staff') { ?>
        <!-- for admin view -->
        <section class="container-fluid">
          <div class="card">
            <div class="card-head">
              <form method="POST" name="form-1" action="" enctype="multipart/form-data">
                <div class="row col-md-12">
                  <div class="col-md-4">
                    <select class="form-control" id="batch" name="batch" >
                      <option value="" selected disabled>Select Batch</option>
                      <?php
                      $login = $_SESSION['email'];
                      $get_batch = mysqli_query($conn, "SELECT batch_no, id FROM tbl_stoc_batch_detail WHERE status = 'Existing' ");
                        while ($option = mysqli_fetch_assoc($get_batch)){                      
                          ?>
                          <option value="<?php echo $option['id'] ?>"><?php echo 'BATCH--'.$option['batch_no']; ?></option>
                          <?php 
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="name_course" name="course" required="">
                      <option value="" disabled selected>Select Course</option>
                    </select>
                  </div>
                  <div class="col-md-10">
                    <textarea placeholder="Enter Message" maxlength="255" class="form-control" name="message" id="message" required=""></textarea>
                  </div>
                  <div class="col-md-2" style="text-align: center;"><br>
                    <input type="submit" class="btn btn-outline-success" value="Submit" name="notice_send">
                  </div>               
                </div>
              </form><br>
            </div>
          </div>
        </section>
      <?php } ?>
      <section>
        <div class="container-fluid">
          <div class="card">
            <div class="card-head">
              <form method="post" action="">
                <div class="row col-md-12">             
                  <div class="col-md-4">
                    <input type="date" id="from_date" class="form-control" name="from_date">
                  </div>
                  <div class="col-md-4">
                    <input type="date" class="form-control" id="to_date" name="to_date">
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-info" name="search" ><span class="fa fa-search"></span></button>
                  </div>            
                </div>
              </form>
            </div>
            <div class="card-body">

              <h3>Notice Detail</h3>
              
              <table class="table table-hovered table-bordered table-responsive">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mesage</th>
                    <?php if($role['title']=='Admin'){?><th>Staff Name</th><?php } ?>
                    <th>Program</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  date_default_timezone_set('Asia/Calcutta');
                  $cdate1  = date("Y-m-d");
                  $cdate2  = date("Y-m-d");
                  if (isset($_REQUEST['search'])) {
                    $cdate1 = $_REQUEST['from_date'];
                    $cdate2 = $_REQUEST['to_date'];
                  }
                  if($role['title'] !='Student'){
                    $login=$_SESSION['email'];
                    if($role['title']=='Staff'){
                      $get_data = mysqli_query($conn, "SELECT * FROM stoc_communication_notice WHERE staff_id='$login' AND created_at >= '$cdate1' AND created_at <= '$cdate2' ");
                    }elseif ($role['title']=='Admin') {
                      $get_data = mysqli_query($conn, "SELECT * FROM stoc_communication_notice WHERE created_at >= '$cdate1' AND created_at <= '$cdate2' ");
                    }
                    $count = 1;
                    if(mysqli_num_rows($get_data) > 0)
                    {
                      while($getList = mysqli_fetch_assoc($get_data))
                      { 
                        $staff_id = $getList['staff_id'];
                        $get_data_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '$staff_id'"));
                        ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td><?php echo $getList['message']; ?></td>
                          <?php if($role['title']=='Admin') { ?><td><?php echo $get_data_name['first_name'].' '.$get_data_name['last_name']; ?></td><?php } ?>
                          <td><?php echo $getList['program']; ?></td>
                          <td><?php echo $getList['created_at']; ?></td>
                        </tr>
                      <?php } ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4" align="middle"><a href="notice_download_pdf.php?stoc&from=<?php echo base64_encode($cdate1); ?>&to=<?php echo base64_encode($cdate2); ?>&type=<?php echo base64_encode($role['title']); ?>&log=<?php echo base64_encode($login); ?>"><button class="btn btn-outline-info">Download</button></a></td>
                      </tr>
                    </tfoot>
                  <?php } else { ?>
                    <tr>
                      <td colspan='5' style="text-align:center;">No Data Available</td>
                    </tr>
                  </tbody>
                <?php } ?>
              <?php }else {
                $login = $_SESSION['email'];
                $get_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_stoc_students WHERE enrollment_no = $login AND status = 'Existing' "));
              
                  $get_data = mysqli_query($conn, "SELECT * FROM stoc_communication_notice WHERE created_at >= '$cdate1' AND created_at <= '$cdate2' AND batch = '".$get_name['course_batch_id']."'");
                
                $count = 1;
                while ($getList = mysqli_fetch_assoc($get_data)) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $getList['message']; ?></td>
                    <td><?php echo $getList['program']; ?></td>
                    <td><?php echo $getList['created_at']; ?></td>
                  </tr>
                <?php } ?> 
              </tbody>
            <?php }?>           
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'include/footer-script.php' ?>
<!-- notification show model -->
<div class="modal" id="notification_model">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="noti_model_head">Oops...</h4>
        <button type="button" class="close" onclick="notiDismiss();" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="noti_model_body"></div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" onclick="notiDismiss();" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    /*date set today*/

    var from_date = document.querySelector('#from_date');
    var to_date = document.querySelector('#to_date');
    var date = new Date();
    // Set the date
    from_date.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);
    to_date.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);

    /*/date set today*/

    $('#batch').on('change', function(){
      var batchVal = $(this).val();
    
        $.ajax({
          url: "communication_backend",
          type: "POST",
          datatype: "JSON",
          data: {
            type: "stoc_get_course",
            batch_value: batchVal
          },

          success: function(res){            
            $('#name_course').html(res);         
          }

        });
    });
    

  });

  function changeStatus(value){
    $.ajax({
      url: "program_module_backend",
      type: "POST",
      datatype: "JSON",
      data: {
        type: "homework_change_status",
        statusId: value
      },

      success: function(response){
        if (response == 'change_successfully') {
          window.location.reload();
        }else{
          console.log('not');
        }
      }
    });
  }
  /*keep date on search*/
  
  function notiDismiss(){
    $('#notification_model').fadeOut();
  }
</script>
</body>
</html>
