<?php

require_once './config.php';
if (!isset($_SESSION["user_id"]) && $_SESSION["user_id"] == "") {
  // user already logged in the site
  header("location:" . SITE_URL);
}
include './header.php';

$success = FALSE;
$error = FALSE;




if(isset($_POST["mode"]) && $_POST["mode"] == "type1") {
  $msg = $_POST["msg"];
  $param = array( 'message' => $msg );
  
  try { 
    $posted = $facebook->api('/me/feed/', 'post', $param);
    if (strlen($posted["id"]) > 0 ) $success = TRUE;
  } catch  (FacebookApiException $e) {
    $errMsg = $e->getMessage();
    $error = TRUE;
  }
 
} else if(isset($_POST["mode"]) && $_POST["mode"] == "type2") {
  $msg = $_POST["msg"];
  $param = array(
    'message' => $msg,
    'link' => "https://www.facebook.com/",
   );
  
  try {
    $posted = $facebook->api('/me/feed/', 'post', $param);
    if (strlen($posted["id"]) > 0 ) $success = TRUE;
  } catch  (FacebookApiException $e) {
    $errMsg = $e->getMessage();
    $error = TRUE;
  }
  
} else if(isset($_POST["mode"]) && $_POST["mode"] == "type3") {

  $param = array(
	'message' => "Posted from www.PHPHive.info",
    'picture' => 'http://www.phphive.info/wp-content/uploads/2014/10/PHPHive.png',
    'caption' => "PHPHive - PHP Lessons, Tutorials, Snippets and More",
    );
 try { 
  $posted = $facebook->api('/me/feed/', 'post', $param);
  if (strlen($posted["id"]) > 0 ) $success = TRUE;
 } catch  (FacebookApiException $e) {
   $errMsg = $e->getMessage();
   $error = TRUE;
 }
} 

?>
<div class="container mainbody">
    <?php if ($error) { ?>
    <div class="alert alert-dismissable alert-warning">
      <button data-dismiss="alert" class="close" type="button">×</button>
      <h4>Oops Some Error Occured !</h4>
      <p><?php echo $errMsg; ?></p>
    </div>
    <?php } else if ($success) { ?>
  <div class="alert alert-dismissable alert-success">
      <button data-dismiss="alert" class="close" type="button">×</button>
      <h4>Success</h4>
      <p>It has been successfully posted to your Timeline.</p>
    </div>
    <?php } ?>
  
  
    <div class="clearfix"></div>
    
    
    <div class="row pull-left">
        <a class="btn btn-primary" href="<?php echo  $logoutURL; ?> "><span class="glyphicon glyphicon-heart"></span> Hi <?php echo $user_profile["name"]; ?></a>
    </div>
    <div class="row pull-right">
        <a class="btn btn-danger" href="<?php echo  $logoutURL; ?> "><span class="glyphicon glyphicon-log-out"></span> Logout</a>
    </div>
    <div class="clearfix"></div>

    
    
    <div class="row">
        <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title">Post Message to your Facebook Timeline </h3>
          </div>
          <div class="panel-body">
            <form class="bs-example form-horizontal" method="post" action="home.php">
              <input type="hidden" name="mode" value="type1" />
              <fieldset>
                  <div class="form-group">
                    <label class="col-lg-2 control-label" for="select">Add Your post description to you Facebook wall</label>
                    <div class="col-lg-10">
                      <input type="text" name="msg" placeholder="Your Message" required class="form-control" autocomplete="off" >
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button class="btn btn-primary" type="submit">Submit</button> 
                    </div>
                  </div>
                </fieldset>
            </form>
          </div>
        </div>
      <div style="height: 10px; clear: both"></div>
        <div class="panel panel-success">

           <?php

           foreach ($data as $item) {

            if (isset($item['full_picture'])) {

               $msg = $item['description'] ;
                $permalink = $item['permalink_url'];

            echo "<a href='".$permalink."'><h3 id='title_list_posts'> ".$msg."</h3></a>><br>";

            echo "<div class='post_img'><img src=".$item['full_picture']." width=500 height=300></div><br>";

            }else{

            echo $item['message']."<br>";

            }
            }?>

        </div>
<!--        <div style="height: 10px; clear: both"></div>-->
<!--        <div class="panel panel-primary">-->
<!--            <div class="panel-heading">-->
<!--                <h3 class="panel-title">Post Message, Link  to your Facebook Timeline </h3>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                <form class="bs-example form-horizontal" method="post" action="home.php">-->
<!--                    <input type="hidden" name="mode" value="type2" />-->
<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-bordered table-hover ">-->
<!--                            <tr>-->
<!--                                <td  class="col-lg-4"><strong>What do you Feel about our Blog "PHPHive":</strong></td>-->
<!--                                <td><input type="text" name="msg" placeholder="Your Message" required class="form-control" autocomplete="off" ></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td><strong>Link:</strong></td>-->
<!--                                <td>http://www.phphive.info</td>-->
<!--                            </tr>-->
<!---->
<!--                        </table>-->
<!--                    </div>-->
<!---->
<!--                    <div class="clearfix"></div>-->
<!--                    <div class="form-group">-->
<!--                        <div class="col-lg-12">-->
<!--                            <button class="btn btn-primary" type="submit">Post and Check your Wall</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!---->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div style="height: 10px; clear: both"></div>-->
<!--        <div class="panel panel-success">-->
<!--            <div class="panel-heading">-->
<!--                <h3 class="panel-title">Post Message,Image and Caption to your Facebook Timeline </h3>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                <form class="bs-example form-horizontal" method="post" action="home.php">-->
<!--                    <input type="hidden" name="mode" value="type3" />-->
<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-bordered table-hover ">-->
<!--                            <tr>-->
<!--                                <td><strong>Message:</strong></td>-->
<!--                                <td>Posted from www.PHPHive.info</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td><strong>Caption:</strong></td>-->
<!--                                <td>PHPHive - PHP Lessons, Tutorials, Snippets and More</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td><strong>Image:</strong></td>-->
<!--                                <td><img src="http://www.phphive.info/wp-content/uploads/2014/10/PHPHive.png" alt="image" style="border: 1px solid #000;" ></td>-->
<!--                            </tr>-->
<!--                        </table>-->
<!--                    </div>-->
<!---->
<!--                    <div class="clearfix"></div>-->
<!--                    <div class="form-group">-->
<!--                        <div class="col-lg-12">-->
<!--                            <button class="btn btn-primary" type="submit">Post and Check your Wall</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!---->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
<?php
include './footer.php';
?>