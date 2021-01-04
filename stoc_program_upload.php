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
$today = date('Y-m-d');
if(isset($_POST['program_curriculum_submit'])) {
  $login = $_SESSION['email'];
  $inserted_by = $role['title'];
  $type = $_POST['type'];
  $student_id = $_POST['student'];
  $course = $_POST['course'];
  $title = mysqli_escape_string($conn, $_POST['title']);   
  $pdf = $_FILES['pdf_upload']['name'];
  $get_ext = strtolower(pathinfo($pdf, PATHINFO_EXTENSION));
  $get_name = strtolower(pathinfo($pdf, PATHINFO_FILENAME));
  $uniq_name = slugify($title).'-'.time();
  $upload_path = "upload/";
  $file_name = $uniq_name.'.'.$get_ext;
  if ($get_ext == 'pdf') {
    if (move_uploaded_file($_FILES['pdf_upload']['tmp_name'], $upload_path.$file_name)) {
        $insert_curriculum = mysqli_query($conn, "INSERT INTO tbl_stoc_upload(type, program_name, student_id, title, file, inserted_by, inserted_id, inserted_date) VALUES('Program Curriculum', '$course','$student_id', '$title', '$file_name', '$inserted_by','$login', '$today')");
        if($insert_curriculum){
          echo "<script>alert('Program Curriculum Successfully Submitted')</script>";
        }else{
          die("Error".mysqli_error($conn));
        }
    }else{
      echo "<script>alert('Image File Is Not Uploading')</script>";
    }
  }else{
    echo "<script>alert('Only PDF File Allowed')</script>";
  }
}
?>
<!DOCTYPE HTML>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aims-Media | Teaching Learning Material </title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php include'include/top-script.php' ?>
  <style type="text/css">
    .col-md-3{
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
                <li class="breadcrumb-item"><a href="home.php">  </a> / upload/View Curriculum</li>
              </ol>
            </div>
            <div class="col-sm-6 float-sm-right"></div>
          </div>
        </div>
      </section>
      <!------Add visitior from------>
      <?php  
      if ($role['title']=='Admin') {
        ?>
        <!-- for admin view -->
        <section class="container-fluid">
          <div class="card">
            <div class="card-head">
              <form method="POST" name="form-1" action="" enctype="multipart/form-data">
                <div class="row col-md-12">
                  <div class="col-md-3">
                    <select class="form-control" id="student_name" name="student" required="">
                      <option selected disabled>Select Student</option>
                      <?php 
                        if($role['title'] == 'Admin'){
                          $get_stu = mysqli_query($conn, "SELECT student_id, applicant_name FROM tbl_stoc_students WHERE status = 'Existing' ORDER BY applicant_name ASC ");
                        }elseif ($role['title'] == 'Staff') {
                          $get_stu = mysqli_query($conn, "SELECT student_id, applicant_name FROM tbl_stoc_students WHERE status = 'Existing' ORDER BY applicant_name ASC ");
                        }
                        while ($data = mysqli_fetch_assoc($get_stu)) { ?>
                          <option value="<?php echo $data['student_id'] ?>"><?php echo $data['applicant_name'] ?></option>
                       <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <select class="form-control" id="name_course" name="course" required="">
                      <option selected disabled>Select Course</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Enter Title" id="title" maxlength='255' name="title" required="">
                  </div>
                  <div class="col-md-3">
                    <input type="file" class="form-control" accept=".pdf" id="pdf_upload" name="pdf_upload" required="">
                  </div>
                  <div class="col-md-3">
                    <input type="submit" class="btn btn-outline-success" value="Submit" name="program_curriculum_submit">
                  </div>               
                </div>
              </form><br>
            </div>
          </div>
        </section>
        <!-- ADMIN list view -->
        <section>
          <div class="container-fluid">
            <div class="card">
              <div class="card-head">
                <h3>Curriculum List</h3>
              </div>
              <div class="card-body">
                <table class="table table-hovered table-bordered table-responsive" style="font-size: small">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Type</th>
                      <th>Student</th>
                      <th>Program</th>
                      <th>Insert By</th>
                      <th>Inserted Name</th>
                      <th>Insert Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $get_data = mysqli_query($conn, "SELECT * FROM tbl_stoc_upload WHERE status = 'active' AND type = 'Program Curriculum' ORDER BY inserted_date DESC");
                    $count = 1;
                    while($getList = mysqli_fetch_assoc($get_data)){ 
                      $get_enroll_name = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE email = '".$getList['inserted_id']."' ");
                      $get_name = mysqli_fetch_assoc($get_enroll_name);
                      ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $getList['title']; ?></td>
                        <td><?php echo $getList['type']; ?></td>
                        <td><?php 
                            $stInfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `applicant_name` FROM `tbl_stoc_students` WHERE `student_id` = '".$getList['student_id']."'"));
                            echo $stInfo['applicant_name']; 
                         ?></td>
                        <td><?php echo $getList['program_name']; ?></td>
                        <td><?php echo $getList['inserted_by']; ?></td>
                        <td><?php echo $get_name['first_name'].' '.$get_name['last_name']; ?></td>
                        <td><?php echo $getList['inserted_date']; ?></td>
                        <td><a href="upload/<?php echo $getList['file']; ?>" target="_blank" class="btn btn-xs btn-outline-info"><span class="fa fa-eye"></span></a><?php if ($getList['status'] == 'active') { ?> <button type="button" onclick="changeStatus(<?php echo $getList['id']; ?>);" class="btn btn-xs btn-outline-danger">Inactive</button><?php } ?></td>
                      </tr>
                    <?php  }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <?php
      }elseif ($role['title']=='Staff') { ?>
        <section class="container-fluid">
          <div class="card">
            <div class="card-head">
              <form method="POST" name="form-1" action="" enctype="multipart/form-data">
                <div class="row col-md-12">
                  <div class="col-md-3">
                    <select class="form-control" id="student_name" name="student" required="">
                      <option selected disabled>Select Student</option>
                      <?php 
                        $login = $_SESSION['email'];
                        $get_student = mysqli_query($conn, "SELECT student_id, applicant_name FROM tbl_stoc_students WHERE status = 'Existing' AND course_batch_id IN(SELECT id FROM tbl_stoc_batch_detail WHERE educator_id IN(SELECT st_id FROM tbl_staff_details WHERE st_email = '$login' AND status = 'Active')) ");
                        while ($data = mysqli_fetch_assoc($get_student)) { ?>
                          <option value="<?php echo $data['student_id'] ?>"><?php echo $data['applicant_name'] ?></option>
                       <?php }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <select class="form-control" id="name_course" name="course" required="">
                      <option selected disabled>Select Course</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Enter Title" id="title" name="title" required="">
                  </div>
                  <div class="col-md-3">
                    <input type="file" class="form-control" accept=".pdf" id="pdf_upload" name="pdf_upload" required="">
                  </div>
                  <div class="col-md-3">
                    <input type="submit" class="btn btn-outline-success" value="Submit" name="program_curriculum_submit">
                  </div>               
                </div>
              </form><br>
            </div>
          </div>
        </section>
        <!-- staff_view_list -->
        <section>
          <div class="container-fluid">
            <div class="card">
              <div class="card-head">
                <h3>Curriculum List</h3>
              </div>
              <div class="card-body">
                <table class="table table-hovered table-bordered table-responsive" style="font-size: none">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Type</th>
                      <th>Student</th>
                      <th>Program</th>
                      <th>Insert By</th>
                      <th>Inserted Name</th>
                      <th>Insert Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $login = $_SESSION['email'];
                    $get_data = mysqli_query($conn, "SELECT * FROM tbl_stoc_upload WHERE type = 'Program Curriculum' AND status = 'active' AND inserted_id = '$login' ORDER BY inserted_date DESC");
                    $count = 1;
                    while($getList = mysqli_fetch_assoc($get_data)){ 
                      $get_enroll_name = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE email = '".$getList['inserted_id']."' ");
                      $get_name = mysqli_fetch_assoc($get_enroll_name);
                      ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $getList['title']; ?></td>
                        <td><?php echo $getList['type']; ?></td>
                        <td><?php 
                            $stInfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `applicant_name` FROM `tbl_stoc_student` WHERE `student_id` = '".$getList['student_id']."'"));
                            echo $stInfo['applicant_name'];      
                         ?></td>
                        <td><?php echo $getList['program_name']; ?></td>
                        <td><?php echo $getList['inserted_by']; ?></td>
                        <td><?php echo $get_name['first_name'].' '.$get_name['last_name']; ?></td>
                        <td><?php echo $getList['inserted_date']; ?></td>
                        <td><a href="upload/<?php echo $getList['file']; ?>" target="_blank" class="btn btn-xs btn-outline-info"><span class="fa fa-eye"></span></a><?php if ($getList['status'] == 'active') { ?> <button type="button" onclick="changeStatus(<?php echo $getList['id']; ?>);" class="btn btn-xs btn-outline-danger">Inactive</button><?php } ?></td>
                      </tr>
                    <?php  }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
      <?php } ?>
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
        $('#student_name').on('change', function(){
          var val = $(this).val();
            $.ajax({
              url: "stoc_upload_backend",
              type: "POST",
              datatype: "JSON",
              data: {
                type: "get_stoc_course",
                value: val
              },
              success: function(res){
                $('#name_course').html(res);
              }
            });
        });
        $('#institute_name').on('change', function(){
          var val = $(this).val();
          var student_type = $('#type').val();
          $.ajax({
            url: "stoc_upload_backend",
            type: "POST",
            datatype: "JSON",
            data: {
              type: "get_insti_indi_course",
              indi_value: val,
              stu_type: student_type
            },
            success: function(res){
              $('#name_course').html(res);
            }
          });
        });
        /*for staafff*/
        $('#staff_student_type').on('change', function(){
          var val = $(this).val();
          var log = $('#login').val();
            $.ajax({
              url: "stoc_upload_backend",
              type: "POST",
              datatype: "JSON",
              data: {
                type: "staff_get_insti_indi",
                indi_value: val,
              },
              success: function(res){
                $('#staff_institute_name').html(res);
              }
            });
        });
        $('#staff_institute_name').on('change', function(){
          var val = $(this).val();
          var student_type = $('#staff_student_type').val();
          $.ajax({
            url: "stoc_upload_backend",
            type: "POST",
            datatype: "JSON",
            data: {
              type: "staff_get_institute_course",
              indi_value: val,
              stu_type: student_type
            },
            success: function(res){
              $('#staff_name_course').html(res);
              
            }
          });
        });
      });
      function changeStatus(value){
        $.ajax({
          url: "stoc_upload_backend",
          type: "POST",
          datatype: "JSON",
          data: {
            type: "change_status",
            statusId: value
          },
          success: function(response){
            if (response == 'change_successfully') {
              alert("Program Successfully Inactive")
              window.location.href='stoc_program_curriculum';
            }
          }
        });
      }
      function notiDismiss(){
        $('#notification_model').fadeOut();
      }
    </script>
  </body>
  </html>
