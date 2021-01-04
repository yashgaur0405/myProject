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
$today = date('Y-m-d');


if (isset($_POST['submit_feedback'])) {
 $feedback = mysqli_escape_string($conn, $_POST['feedback']);
 $type = $role['title'];
 $type_id = $_SESSION['email'];
 $insert_feedback = mysqli_query($conn, "INSERT INTO stoc_communication_feedback(type, type_id, message, created_at) VALUES('$type', '$type_id', '$feedback', '$today') ");
 if ($insert_feedback) {
  echo "<script>alert('Your feedback has been submitted, our authorized person will revert you asap.')</script>";
}else{
  die("ERROR: ".mysqli_error($conn));
}
}
if (isset($_POST['submit_reply'])) {
  $feedback_id = $_POST['reply_feedback_id'];
  $reply_content = mysqli_escape_string($conn, $_POST['reply_box']);
  $insert_reply = mysqli_query($conn, "INSERT INTO stoc_feedback_reply(feedback_id, type, type_id, reply_mess, created_at) VALUES('$feedback_id', '".$role['title']."', '".$_SESSION['email']."', '$reply_content', '$today')");
  if ($insert_reply) {
    echo "<script>alert('Your Reply SuccessFully Submitted')</script>";
  }else{
    die("Error:".mysqli_error($conn));
  }
}
?>

<!DOCTYPE HTML>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aims-Media | Feedback</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <?php include'include/top-script.php' ?>
  <style type="text/css">
    .reply_box:focus{
      outline: none;
    }
    /*.feedback{
      border-top: 1px solid black;
      }*/
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
                  <li class="breadcrumb-item"><a href="home.php">  </a> / Add Or View Feedback</li>
                </ol>
              </div>
              <div class="col-sm-6 float-sm-right"></div>
            </div>
          </div>
        </section>
        <!------Add visitior from------>
        <?php if($role['title'] != 'Admin' || $role['title'] == 'Staff') {?>
          <section>
            <div class="container-fluid">
              <div class="card primary">
                <div class="container">              
                  <div class="card-head">
                    <br>
                    <form method="POST">
                      <div class="row col-md-12">
                        <div class="col-md-11">
                          <textarea placeholder="Add Your Feedback" name="feedback" class="form-control" required></textarea>
                        </div>
                        <div class="col-md-1">
                          <br><input type="submit" class="btn btn-success" value="Submit" name="submit_feedback">
                        </div>                                 
                      </div>
                    </form><br>  
                  </div>                 
                </div>
              </div>
            </div>
          </section>
        <?php } ?>
        <section>
          <div class="container-fluid">
            <div class="card"><br>
              <div class="card-head container">
                <h3>Feedback List:</h3><br>
              </div>
              <div class="card-body">
                <form method="POST" action="">
                  <div class="col-md-12 row">
                    <div class="col-md-5">
                      <label for="from">From:</label>
                      <input type="date" class="form-control" id="from_date" name="from_date" required="">
                    </div>
                    <div class="col-md-5">
                      <label for="to">To:</label>
                      <input type="date" class="form-control" id="to_date" name="to_date" required="">
                    </div>
                    <div class="col-md-2">
                      <button type="submit" class="btn btn-outline-info" name="submit_search" style="margin-top: 30px"><span class="fa fa-search"></span></button>
                    </div>
                  </div>
                </form>   
              </div>
              <div class="card-body">
                <?php 
                $date_from = date('Y-m-d');
                $date_to = date('Y-m-d');

                if (isset($_REQUEST['submit_search'])) {
                  $date_from = $_REQUEST['from_date'];
                  $date_to = $_REQUEST['to_date'];
                }

                if ($role['title'] == 'Admin') { ?>
                  <div class="container">
                    <?php 
                    $count=1;
                    $login = $_SESSION['email'];
                    $get_feedback = mysqli_query($conn, "SELECT * FROM stoc_communication_feedback WHERE created_at >= '$date_from' AND created_at <= '$date_to' ");
                    if(mysqli_num_rows($get_feedback) > 0){
                      while ($listFeedback = mysqli_fetch_assoc($get_feedback)) { 
                        $get_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '".$listFeedback['type_id']."' "));
                        $get_replies = mysqli_query($conn, "SELECT * FROM stoc_feedback_reply WHERE feedback_id = '".$listFeedback['id']."' ORDER BY created_at DESC ");
                        $no_of_replies = mysqli_num_rows($get_replies);
                        ?>              
                        <p class="feedback">
                          <div class="row col-md-12">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                              <h6><span class="fa fa-user" style="float: left; font-weight: bold; font-size: 16px; ">&nbsp;&nbsp;<?php echo $get_name['first_name'].' '.$get_name['last_name'].'('.$listFeedback['type'].')&nbsp;'; ?></span></h6>
                            </div><br>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                              <p><span class="fa fa-comments text-info"  style="float: left;">&nbsp;&nbsp;&nbsp;<?php echo $listFeedback['message'] ?></span></p>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                              <p><span style="color: lightgrey; float: left; margin-left: 30px"><?php echo date_format(date_create($listFeedback['created_at']),'d-M-Y'); ?></span><span style="float: right; margin-right: 50px"><a data-toggle="collapse" href="#collapseExample<?php echo $count; ?>" aria-expanded="false" aria-controls="collapseExample" style="width: 100%;">Replies<?php echo ' ('.$no_of_replies.')' ?></a></span></p>
                            </div>
                          </div>
                        </p><hr>
                        <div class="collapse" id="collapseExample<?php echo $count; ?>">
                          <div class="card container card-body">
                            <?php while ($getAllReplies = mysqli_fetch_assoc($get_replies)) { 
                              $get_replies_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '".$getAllReplies['type_id']."'"));
                              ?>
                              <h6><span class="fa fa-arrow-right" style="float: left">&nbsp;</span><span style="float: left; font-weight: bold; font-size: 16px; "><?php if($_SESSION['email'] == $getAllReplies['type_id']){ echo 'You:&nbsp;'; }else{ echo $get_replies_name['first_name'].' '.$get_replies_name['last_name'].'('.$getAllReplies['type'].'):&nbsp; ';} ?></span><span><?php echo $getAllReplies['reply_mess'] ?></span><span style="color: lightgrey; float: right"><?php echo date_format(date_create($getAllReplies['created_at']),'d-M-Y'); ?></span></h6>
                            <?php } ?>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                              <hr>
                              <form method="POST" action="" style="float: right;">                           
                                <input type="hidden" value="<?php echo $listFeedback['id']; ?>" name="reply_feedback_id">
                                <input type="text" maxlength="255" name="reply_box" class="reply_box" placeholder="Reply" required style="border: none; border-bottom: 1px solid black">&nbsp;
                                <button type="submit" value="Send" class="btn btn-outline-success" name="submit_reply" style="padding: 2px 5px 2px 5px;"><span class="fa fa-reply"></span></button>
                              </form>
                            </div>
                          </div>
                        </div>
                        <?php $count++; }}else{ ?>
                          <p>
                            <div class="col-md-12">
                              <h4 style="text-align: center"><span class="fa fa-ban">&nbsp;No Data</span></h4>
                            </div>
                          </p>
                        <?php } ?>
                      </div>
                    <?php }elseif($role['title'] == 'Staff'){ ?>
                      <div class="container">
                        <?php 
                        $count=1;
                        $login = $_SESSION['email'];
                        $get_feedback = mysqli_query($conn, "SELECT * FROM stoc_communication_feedback WHERE created_at >= '$date_from' AND created_at <= '$date_to' AND type_id = '$login' ");
                        if(mysqli_num_rows($get_feedback) > 0){
                          while ($listFeedback = mysqli_fetch_assoc($get_feedback)) { 
                            $get_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '".$listFeedback['type_id']."' "));
                            $get_replies = mysqli_query($conn, "SELECT * FROM stoc_feedback_reply WHERE feedback_id = '".$listFeedback['id']."' ORDER BY created_at DESC ");
                            $no_of_replies = mysqli_num_rows($get_replies);
                            ?>              
                            <p>
                              <div class="row col-md-12">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                                  <h6><span class="fa fa-user" style="float: left; font-weight: bold; font-size: 16px; ">&nbsp;&nbsp;<?php if($listFeedback['type'] == 'Staff'){ echo $get_name['first_name'].' '.$get_name['last_name'];}else{ echo $get_name['first_name'].' '.$get_name['last_name'].'('.$listFeedback['type'].')&nbsp;'; } ?></span></h6>
                                </div><br>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                                  <p><span class="fa fa-comments text-info"  style="float: left;">&nbsp;&nbsp;&nbsp;<?php echo $listFeedback['message'] ?></span></p>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                                  <p><span style="color: lightgrey; float: left; margin-left: 30px"><?php echo date_format(date_create($listFeedback['created_at']),'d-M-Y'); ?></span><span style="float: right; margin-right: 50px"><a data-toggle="collapse" href="#collapseExample<?php echo $count; ?>" aria-expanded="false" aria-controls="collapseExample" style="width: 100%;">Replies<?php echo ' ('.$no_of_replies.')' ?></a></span></p>
                                </div>
                              </div>
                            </p><hr>
                            <div class="collapse" id="collapseExample<?php echo $count; ?>">
                              <div class="card container card-body">
                                <?php while ($getAllReplies = mysqli_fetch_assoc($get_replies)) { 
                                  $get_replies_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '".$getAllReplies['type_id']."'"));
                                  ?>
                                  <h6><span style="float: left; font-weight: bold; font-size: 16px; "><?php if($getAllReplies['type'] == 'Admin'){ echo 'Admin:&nbsp;&nbsp;' ;}elseif($_SESSION['email'] == $getAllReplies['type_id']){ echo 'You:&nbsp;'; }else{ echo $get_replies_name['first_name'].' '.$get_replies_name['last_name'].'('.$getAllReplies['type'].'): ';} ?></span><span><?php echo $getAllReplies['reply_mess'] ?></span><span style="color: lightgrey; float: right"><?php echo date_format(date_create($getAllReplies['created_at'], 'd-M-Y')); ?></span></h6>
                                <?php } ?>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12"><hr>
                                  <form method="POST" action="" style="float: right;">                              
                                    <input type="hidden" value="<?php echo $listFeedback['id']; ?>" name="reply_feedback_id">
                                    <input type="text" maxlength="255" name="reply_box" class="reply_box" placeholder="Reply" style="border: none; border-bottom: 1px solid black">&nbsp;
                                    <input type="submit" value="Send" class="btn btn-success" name="submit_reply" style="padding: 2px 3px 2px 3px;" style="float: right">
                                  </form>
                                </div>
                              </div>
                            </div>
                            <?php $count++; } }else{ ?>
                              <p>
                                <div class="col-md-12">
                                  <h4 style="text-align: center"><span class="fa fa-ban">&nbsp;No Data</span></h4>
                                </div>
                              </p>
                            <?php } ?>
                          </div>
                        <?php }elseif ($role['title'] == 'Student') { ?>
                              <div class="container">
                                <?php 
                                $count=1;
                                $login = $_SESSION['email'];
                                $get_feedback = mysqli_query($conn, "SELECT * FROM stoc_communication_feedback WHERE type_id = '$login' AND created_at >= '$date_from' AND created_at <= '$date_to' ");
                                if(mysqli_num_rows($get_feedback) > 0){
                                  while ($listFeedback = mysqli_fetch_assoc($get_feedback)) { 
                                    $get_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '".$listFeedback['type_id']."' "));
                                    $get_replies = mysqli_query($conn, "SELECT * FROM stoc_feedback_reply WHERE feedback_id = '".$listFeedback['id']."' ORDER BY created_at DESC ");
                                    $no_of_replies = mysqli_num_rows($get_replies);
                                    ?>              
                                    <p>
                                      <div class="row col-md-12">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                                          <h6><span class="fa fa-user" style="float: left; font-weight: bold; font-size: 16px; ">&nbsp;&nbsp;<?php echo $get_name['first_name'].' '.$get_name['last_name'].' '; ?></span></h6>
                                        </div><br>
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                                          <p><span class="fa fa-comments text-info"  style="float: left;">&nbsp;&nbsp;&nbsp;<?php echo $listFeedback['message'] ?></span></p>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                                          <p><span style="color: lightgrey; float: left; margin-left: 30px"><?php echo date_format(date_create($listFeedback['created_at']),'d-M-Y'); ?></span><span style="float: right; margin-right: 50px"><a data-toggle="collapse" href="#collapseExample<?php echo $count; ?>" aria-expanded="false" aria-controls="collapseExample" style="width: 100%;">Replies<?php echo ' ('.$no_of_replies.')' ?></a></span></p>
                                        </div>
                                      </div>
                                    </p><hr>
                                    <div class="collapse" id="collapseExample<?php echo $count; ?>">
                                      <div class="card container card-body">
                                        <?php while ($getAllReplies = mysqli_fetch_assoc($get_replies)) { 
                                          $get_replies_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '".$getAllReplies['type_id']."'"));
                                          ?>
                                          <h6><span style="float: left; font-weight: bold; font-size: 16px; "><?php if($getAllReplies['type'] == 'Admin'){ echo 'Admin:&nbsp;&nbsp;' ;}elseif($_SESSION['email'] == $getAllReplies['type_id']){ echo 'You:&nbsp;'; }else{ echo $get_replies_name['first_name'].' '.$get_replies_name['last_name'].'('.$getAllReplies['type'].'): ';} ?></span><span><?php echo $getAllReplies['reply_mess'] ?></span><span style="color: lightgrey; float: right"><?php echo date_format(date_create($getAllReplies['created_at'], 'd-M-Y')); ?></span></h6>
                                        <?php } ?>
                                        <div><hr>
                                          <form method="POST" action="" style="float: right;">  
                                            <input type="hidden" value="<?php echo $listFeedback['id']; ?>" name="reply_feedback_id">
                                            <input type="text" maxlength="255" name="reply_box" class="reply_box" placeholder="Reply" style="border: none; border-bottom: 1px solid black">&nbsp;
                                            <input type="submit" value="Send" class="btn btn-success" name="submit_reply" style="padding: 2px 3px 2px 3px;" style="float: right">
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    <?php $count++; }}else{ ?>
                                      <p>
                                        <div class="col-md-12">
                                          <h4 style="text-align: center"><span class="fa fa-ban">&nbsp;No Data</span></h4>
                                        </div>
                                      </p>
                                    <?php } ?>
                                  </div>
                                <?php } ?>
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

                        /*date set today*/

                          var from_date = document.querySelector('#from_date');
                          var to_date = document.querySelector('#to_date');
                          var date = new Date();
                          // Set the date
                          from_date.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);
                          to_date.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);

                          /*/date set today*/

                        function notiDismiss(){
                          $('#notification_model').fadeOut();
                        }
                      </script>
                    </body>
                    </html>
