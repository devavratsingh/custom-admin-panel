<?php
session_start();
require("config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../sign-in.php");
}
if(isset($_GET['id'])){
  $productid = $_GET['id']; 
}
//get product name
$queryget = mysqli_query($conn, "SELECT * FROM products WHERE id='$productid'");
$resultset = mysqli_fetch_assoc($queryget);
$proname = $resultset['product_name'];
// get category name
$catid = $resultset['product_category'];
$catset = mysqli_query($conn, "SELECT * FROM categories WHERE id='$catid'");
$resultcat = mysqli_fetch_assoc($catset);
$catname = $resultcat['cat_name'];
//get the user name from session
$username = $_SESSION['username'];
$active = "products";
$result = mysqli_query($conn, "SELECT * FROM users WHERE mr_art_export_username='$username'");
$user = mysqli_fetch_assoc($result);
$username = $user['mr_art_export_username'];
$email = $user['mr_art_export_email'];
$userid = $user['id'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Devavrat Singh, Sat Sai Infocom">
    <meta name="generator" content="SAT SAI INFOCOM">
    <title>Upload Images for Product - MR ART EXPORTS</title>
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
        <h1 class="display-4">Upload Multiple Images for <?php echo $proname; ?> in <?php echo $catname; ?></h1>
        <form role="form" method="POST" autocomplete="off" enctype="multipart/form-data" name="formUploadFile" id="uploadForm">
          <div id="displayMessage"></div>
          <div class="modal-body">
            <div class="form-group">
              <label for="uploadInputFile">Select Images to Upload:</label>
              <input type="hidden" value="<?php echo $productid; ?>" id="productid">
              <input type="hidden" value="<?php echo $userid; ?>" id="userid">
              <input type="file" class="form-control" id="uploadFileInput" name="files[]" multiple="multiple">
              <small id="uploadHelp" class="form-text text-muted"><span class="label label-info">Note:</span> Please, Select the only images (.jpg, .jpeg, .png, .gif) to upload with the size of 100KB only.</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="startUpload">Start Upload</button>
            <button onclick="location.reload();" class="btn btn-info">Refresh Page & See Uploaded Images</button>
          </div>
          
          
          
        </form>
      </div>
      <?php 
      // Display table here 
      ?>
    <div class="col-12 col-md-12 themed-grid-col p-4 shadow-lg">
      <h1 class="display-4">Image List</h1>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Sr. No.</th>
              <th>Image Path</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Images</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $catquery = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$productid'"); 
            $i = 1;
            while($rescat = mysqli_fetch_assoc($catquery)) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $rescat['ImagePath']; ?></td>
              <td><?php echo $proname; ?></td>
              <td><?php echo $catname; ?></td>
              <td>
                  <img src="<?php echo $rescat['ImagePath']; ?><?php echo $rescat['ImageFileName']; ?>" alt="<?php echo $rescat['product_id']; ?>" class="rounded" width="50px">
              </td>
              <td>
                <a href="delete/deletepro.php?id=<?php echo $rescat['id']; ?>" class="btn btn-primary">Delete</a>
              </td>
            </tr>
         <?php $i++; } ?>
          </tbody>
        </table>
      </div
    </div>
  </div>
    </main>
  </div>
</div>
<script type="text/javascript">
const url = 'process.php';
const form = document.querySelector('form');
form.addEventListener('submit', e => {
  e.preventDefault();
  const idvalue = document.getElementById('productid').value;
  const userid = document.getElementById('userid').value;
  const files = document.querySelector('[type=file]').files;
  const formData = new FormData();
  for(let i =0; i < files.length; i++) {
    let file = files[i];
    formData.append('files[]', file);
  }
  formData.append('id', idvalue);
  formData.append('uid', userid);
  console.log(formData);
  //if(window.XMLHttpRequest)
  fetch(url, {
    method: 'POST',
    body: formData
  }).then(response => response.text()
  .then(text => {
    document.getElementById('displayMessage').innerHTML = text;
  }));
});
</script>
<script src="../../js/jquery.slim.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/feather.min.js"></script>
</body>
</html>
