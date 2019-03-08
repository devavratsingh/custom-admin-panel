<?php
session_start();
require("config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../sign-in.php");
}
$username = $_SESSION['username'];
$active = "products";
$result = mysqli_query($conn, "SELECT * FROM users WHERE mr_art_export_username='$username'");
$user = mysqli_fetch_assoc($result);
$username = $user['mr_art_export_username'];
$email = $user['mr_art_export_email'];
$userid = $user['id'];
$active = 'settings';
if(isset($_POST) & !empty($_POST)){
  $weburl = mysqli_real_escape_string($conn, $_POST['weburl']);
  if(isset($_POST['indexvalue'])) {
    $index = $_POST['indexvalue'];
  } else {
    $index = $_POST['indexvalue'];
  }
  $metdes = mysqli_real_escape_string($conn, $_POST['metadescription']);
  $metakey = mysqli_real_escape_string($conn, $_POST['metakeywords']);
  $facebooklink = mysqli_real_escape_string($conn, $_POST['facebooklink']);
  $twitterlink = mysqli_real_escape_string($conn, $_POST['twitterlink']);
  $concontent = mysqli_real_escape_string($conn, $_POST['contactUsContent']);
  $companyname = mysqli_real_escape_string($conn, $_POST['comname']);
  $ownername = mysqli_real_escape_string($conn, $_POST['ownername']);
  $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
  $address2 = mysqli_real_escape_string($conn, $_POST['address2']);
  $address = $address1." <br/>".$address2;
  $contact1 = mysqli_real_escape_string($conn, $_POST['contact1']);
  $contact2 = mysqli_real_escape_string($conn, $_POST['contact2']);
  $email1 = mysqli_real_escape_string($conn, $_POST['email1']);
  $email2 = mysqli_real_escape_string($conn, $_POST['email2']);
  date_default_timezone_set("Asia/Kolkata");
  $date = date("Y-m-d H:i:s");
  $checking = mysqli_query($conn, "SELECT * FROM settings");
  $rownum = mysqli_num_rows($checking);
  $query = "UPDATE `settings` SET `website_url` = '$weburl', `indexweb` = '$index', `meta_description` = '$metdes', `meta_keywords` = '$metakey', `social_link1` = '$facebooklink', `social_link2` = '$twitterlink', `contact_page_desc` = '$concontent', `company_name` = '$companyname', `owner_name` = '$ownername', `address` = '$address', `contact_num1` = '$contact1', `contact_num2` = '$contact2', `email1` = '$email1', `email2` = '$email2', `userid` = '$userid', `modified` = '$date'";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  if($result){
    $smsm = "Settings Updated Successfully.";
  } else {
    $smsm = "Form Submission Failed";
  }
} ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Devavrat Singh, Sat Sai Infocom">
    <meta name="generator" content="SAT SAI INFOCOM">
    <title>Settings - MR ART EXPORTS</title>
    <!-- Bootstrap core CSS -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <?php include("../navigation/top-navigation.php"); ?>
<div class="container-fluid">
  <div class="row">
    <?php include("../navigation/inner-navigation.php"); ?>

    <main role="main" class="col-md-12 ml-sm-auto col-lg-10 px-4">
      <?php if(isset($message)) {?><div class="alert alert-danger" role="alert"><?php echo $message; ?></div><?php } ?>
     <?php if(isset($smsm)) { ?> <div class="alert alert-success" role="alert"><?php echo $smsm; ?></div><?php } ?>
      
      <div class="row mb-3">

      <div class="col-12 col-md-12 themed-grid-col p-4 shadow-lg">
        <h1 class="display-1">Settings</h1>
        <?php 
        $selquery = mysqli_query($conn, "SELECT * FROM settings");
        $resultset = mysqli_fetch_assoc($selquery);
        ?>
        <form role="form" method="POST" autocomplete="off" name="settingform" id="settingform">
          <div id="displayMessage"></div>
          <div class="modal-body">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">Website Url</span>
                </div>
                <input type="text" name="weburl" class="form-control"  placeholder="Website Link" aria-descripbedby="basic-addon3" value="<?php echo $resultset['website_url']; ?>">
              </div>
            <div class="form-group form-check m-4">
              <input type="checkbox" class="form-check-input" value="1" name="indexvalue" <?php if($resultset['indexweb'] == 1) { echo "checked";} ?> >
              <label class="form-check-label" for="indexvalue">Check this box if you want to make your website Search Engine Accessible</label>
            </div>
            <div class="form-group col-sm">
              <label for="categoryInputName">Meta Description</label>
              <textarea placeholder="Enter Meta Description" class="span-4 m-wrap form-control" name="metadescription" aria-describedby="metadesHelp"><?php echo $resultset['meta_description']; ?></textarea>
              <small id="metadesHelp" class="form-text text-muted">Enter the meta description of your website home page.</small>
            </div>
            <div class="form-group col-sm">
              <label for="categoryInputName">Meta Keywords</label>
              <textarea placeholder="Enter Meta Keywords" class="span-4 m-wrap form-control" name="metakeywords" aria-describedby="metadesHelp"><?php echo $resultset['meta_keywords']; ?></textarea>
              <small id="metadesHelp" class="form-text text-muted">Enter the meta description of your website home page.</small>
            </div>
            <hr>
            <h2 class="display-4">Social Links</h2>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">https://www.facebook.com/</span>
                </div>
                <input type="text" name="facebooklink" class="form-control"  placeholder="Facebook Link" aria-descripbedby="basic-addon3" value="<?php echo $resultset['social_link1']; ?>">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">https://www.twitter.com/</span>
                </div>
                <input type="text" name="twitterlink" class="form-control" placeholder="Twitter Link" aria-descripbedby="basic-addon3">
              </div>
              <hr>
            <h2 class="display-4">Contact Details</h2>
            <div class="form-group col-sm">
              <label for="categoryInputName">Contact Page Content</label>
              <textarea placeholder="Enter Content for Contact Us Page" class="span-4 m-wrap form-control" name="contactUsContent" aria-describedby="contactHelp"></textarea>
              <small id="contactHelp" class="form-text text-muted">Enter the description of contact us page.</small>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Company Name</span>
              </div>
              <input type="text" name="comname" class="form-control" placeholder="Enter Company Name" aria-descripbedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Owner Name</span>
              </div>
              <input type="text" name="ownername" class="form-control" placeholder="Enter Company Owner Name" aria-descripbedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Address line 1</span>
              </div>
              <input type="text" name="address1" class="form-control" placeholder="Address 1" aria-descripbedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Address line 2</span>
              </div>
              <input type="text" name="address2" class="form-control" placeholder="Address 2" aria-descripbedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Contact 1</span>
              </div>
              <input type="text" name="contact1" class="form-control" placeholder="Contact 1" aria-descripbedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Contact 2</span>
              </div>
              <input type="text" name="contact2" class="form-control" placeholder="Contact 2" aria-descripbedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Email 1</span>
              </div>
              <input type="text" name="email1" class="form-control" placeholder="Enter Your First Email Address" aria-descripbedby="basic-addon3">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Email 2</span>
              </div>
              <input type="text" name="email2" class="form-control" placeholder="Enter Your Second Email Address" aria-descripbedby="basic-addon3">
            </div>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="startUpload">Save</button>
          </div>
        </form>
      </div>
      <?php 
      // Display table here 
      ?>
    </main>
  </div>
</div>

<script src="../../js/jquery.slim.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/feather.min.js"></script>
</body>
</html>
