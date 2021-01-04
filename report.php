<?php 
session_start();
if (!isset($_SESSION['email'])) {
  header('location:index.php');
}
include_once 'include/config.php';
$role_id = $_SESSION['role_id']; 
$getRole = mysqli_query($conn, "SELECT `title` FROM `tbl_user_role` WHERE `id` = $role_id");
$role = mysqli_fetch_assoc($getRole);

$today = date('Y-m-d');
?>
<!DOCTYPE.HTML>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aims-Media | Database</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <?php include'include/top-script.php' ?>
  <style type="text/css">
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: #f1f1f1;
    }
    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }
    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }
    /* Create an active/current tablink class */
    .tab button.active {
      background-color: #ccc;
    }
    /* Style the tab content */
    #STOC, #JCQT{
      display: none;
    }
    .tabcontent {
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
  </style>
  <script type="text/javascript">
    $( function() {
      $( "#accordion" ).accordion();
      $( "#accordion > h3").css({"background": "lightgrey", "color":"Black", });
    } );
  </script>
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
                <li class="breadcrumb-item"><a href="home.php">  </a> / Database</li>
              </ol>
            </div>
            <div class="col-sm-6 float-sm-right"></div>
          </div>
        </div>
      </section>
      <!------Add visitior from------>
      <section class="content">
        <div class="container-fluid">
         <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card w-100" style="box-shadow:5px 2px 2px;">
            <div class="card-header" style="text-align:center;">
              <div class="tab">
                <button class="tablinks active" onclick="programTabs(event, 'AEMP')">AEMP</button>
                <button class="tablinks" onclick="programTabs(event, 'STOC')">STOC</button>
                <button class="tablinks" onclick="programTabs(event, 'JCQT')">JCQT</button>
              </div>
            </div>
            <div class="card-body  w-100 pad table-responsive tabcontent" id="AEMP">
              <div class="row ml-2">
               <div class="col-md-6">
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="complete_terminate_associates.php"> 1. Completed and Terminated Associative Partners</a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="complete_terminate_student.php"> 2. Graduate and Drop Out Student Details  </a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="inactive-program-curriculum.php"> 3. Inactive Program curriculum </a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="inactive-teaching-learning-material.php"> 4. Inactive Teaching Learning Material  </a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="inactive-homework-detail.php"> 5. Inactive Home-Work Detail  </a></p>
              </div>
              <div class="col-md-6">
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="active-associate-partner-detail.php"> 6. Active Associative Partners  </a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="active-student-detail.php"> 7. Existing Student Detail  </a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="cq_but_not_enrolled.php"> 8. CQ But Not Enrolled  </a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="inactive-previous-summary.php"> 9. Inactive Previous Summary  </a></p>
                <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="inactive-certificate-progressive.php"> 10. Inactive Certificate And Progressive Report  </a></p>
                <!-- <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="news_event_report.php"> 11. News and Events Report  </a></p> -->
              </div>
            </div>
          </div>
          <!-- ---------------------for stoc----------------------------- -->
          <div class="card-body  w-100 pad table-responsive tabcontent" id="STOC">
            <div class="row ml-2">
             <div class="col-md-6">
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc_complete_terminate_batches.php"> 1. Completed and Terminated Batch Details</a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc_complete_terminate_student.php"> 2. Graduate and Drop Out Student Details  </a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc-inactive-program-curriculum.php"> 3. Inactive Program curriculum </a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc-inactive-teaching-learning-material.php"> 4. Inactive Teaching Learning Material  </a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc-inactive-homework-detail.php"> 5. Inactive Home-Work Detail  </a></p>
            </div>
            <div class="col-md-6">
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="active-batch-detail.php"> 6. Active Batch Details  </a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc_active-student-detail.php"> 7. Existing Student Detail  </a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc_cq_but_not_enrolled.php"> 8. CQ But Not Enrolled  </a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc-inactive-previous-summary.php"> 9. Inactive Previous Summary  </a></p>
              <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="stoc-inactive-certificate-progressive.php"> 10. Inactive Certificate And Progressive Report  </a></p>
              <!-- <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="news_event_report.php"> 11. News and Events Report  </a></p> -->
            </div>
          </div>
        </div>
        <!-- ---------------------JCQT--------------------------------- -->
        <div class="card-body  w-100 pad table-responsive tabcontent" id="JCQT">
          <h2>Not Yet</h2>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
   <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card w-100" style="box-shadow:5px 2px 2px;">
      <div class="card-header" style="text-align:center;">
        <h5 class="float-left text-secondary">Other Reports</h5>
      </div>
      <div class="card-body  w-100 pad table-responsive">
        <div class="row ml-2">
         <div class="col-md-6">
          <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="newsletter.php"> 1. News Letter</a></p>
          <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="notification-detail.php"> 2. Notification History  </a></p>
        </div>
        <div class="col-md-6">
          <p style="margin-bottom: 4px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="news_event_report.php"> 3. Inactive Announcements </a></p>
        </div>
      </div>
    </div>
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
  function programTabs(evt, Program) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(Program).style.display = "block";
    evt.currentTarget.className += " active";
  }
  function notiDismiss(){
    $('#notification_model').fadeOut();
  }
</script>
</body>
</html>
