<?php
session_start();
require("config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../sign-in.php");
}
$username = $_SESSION['username'];
$active = "categories";
$result = mysqli_query($conn, "SELECT * FROM users WHERE mr_art_export_username='$username'");
        $user = mysqli_fetch_assoc($result);

        $username = $user['mr_art_export_username'];
        $email = $user['mr_art_export_email'];
        $userid = $user['id'];
        if(isset($_POST) & !empty($_POST)){
          $name = mysqli_real_escape_string($conn, $_POST['name']);
          //$urlimg = mysqli_real_escape_string($mysqli, $_POST['imgurl']);
          $description = mysqli_real_escape_string($conn, $_POST['description']);
          date_default_timezone_set("Asia/Kolkata");
          $date = date("Y-m-d H:i:s");
          $lowercase = strtolower($name);
          $url = str_replace(" ", "-", $lowercase);
          $checking = mysqli_query($conn, "SELECT * FROM categories WHERE cat_name='$name'");
          $rownum = mysqli_num_rows($checking);
          if($rownum > 1) {
             $message = "Category Already Added.";
          } else {
          $query = "INSERT INTO categories (cat_name, cat_desc, cat_slug, user_id, created, modified) VALUES ('$name', '$description', '$url', '$userid', '$date', '$date')";
          $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          if($result){
            $smsm = "Category Added Successfully.";
          } else {
            $smsm = "Form Submission Failed";
          }
          }
        }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Devavrat Singh, Sat Sai Infocom">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Categories - MR ART EXPORTS</title>
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

    <main role="main" class="col-md-12 ml-sm-auto col-lg-10 px-4 m-4 shadow">
      <?php if(isset($message)) {?><div class="alert alert-danger" role="alert"><?php echo $message; ?></div><?php } ?>
     <?php if(isset($smsm)) { ?> <div class="alert alert-success" role="alert"><?php echo $smsm; ?></div><?php } ?>
      
      <div class="row mb-3">
      <div class="col-6 col-md-6 themed-grid-col p-4">
        <h1 class="display-4">Add Category</h1>
        <form action="" method="POST" autocomplete="off">
          <div class="form-group">
            <label for="categoryInputName">Category Name</label>
            <input type="text" placeholder="Enter Category Name" class="span4 m-wrap form-control" name="name" required="" aria-describedby="categoryHelp">
            <small id="categoryHelp" class="form-text text-muted">Enter the Category of your Product.</small>
          </div>
          <div class="form-group">
            <label for="categoryDescription">Category Description</label>
            <textarea class="span4 m-wrap form-control" aria-descibedby="categorytextareaHelp" name="description"></textarea>
            <small id="categorytextareaHelp" class="form-text text-muted">Enter the Category Description of your Product.</small>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    <div class="col-6 col-md-6 themed-grid-col p-4 shadow">
      <h1 class="display-4">Categories List</h1>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Sr. No.</th>
              <th>Category</th>
              <th>Image</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $catquery = mysqli_query($conn, "SELECT * FROM categories"); 
            $i = 1;
            while($rescat = mysqli_fetch_assoc($catquery)) { 
              $catid = $rescat['id'];
              //get product id
              $getproid = mysqli_query($conn, "SELECT * FROM products WHERE product_category='$catid'");
              $getprores = mysqli_fetch_assoc($getproid);
              $getproidnow = $getprores['id'];
              //finally get the image link & url
              $getimg = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$getproidnow'");
              $getimgres = mysqli_fetch_assoc($getimg);
              $rowcount=mysqli_num_rows($getimg);
              ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $rescat['cat_name']; ?></td>
              <td>
                <?php if($getimgres < 1){} else { ?>
                <img src="<?php echo $getimgres['ImagePath']; ?><?php echo $getimgres['ImageFileName']; ?>" alt="<?php echo $rescat['product_name']; ?>" class="rounded" width="50px">
                <?php } ?>
              </td>
              <td><?php echo $rescat['cat_desc']; ?></td>
              <td><button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#editcategory" data-whatever="@edit">Edit</button><a href="delete/deletecat.php?id=<?php echo $rescat['id']; ?>" class="btn btn-primary">Delete</a>
                <div class="modal fade" id="editcategory" tabindex="-1" role="form" aria-labelledby="CategoryEditForm" aria-hidden="true">
                  <div class="modal-dialog" role="form">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ExampleModalLabel">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="categoryInputName">Category Name</label>
                              <input type="text" value="<?php echo $rescat['cat_name']; ?>" class="span4 m-wrap form-control" name="name" required="" aria-describedby="categoryHelp">
                              <small id="categoryHelp" class="form-text text-muted">Enter the Category of your Product.</small>
                            </div>
                            <div class="form-group">
                              <label for="categoryInputName">Image Url</label>
                              <input type="text" value="<?php echo $rescat['cat_image']; ?>" class="span4 m-wrap form-control" name="name" required="" aria-describedby="categoryHelp">
                              <small id="categoryHelp" class="form-text text-muted">Enter the Image URL of your Product in this category.</small>
                            </div>
                            <div class="form-group">
                              <label for="categoryDescription">Category Description</label>
                              <textarea class="span4 m-wrap form-control" aria-descibedby="categorytextareaHelp" name="description"><?php echo $rescat['cat_desc']; ?></textarea>
                              <small id="categorytextareaHelp" class="form-text text-muted">Enter the Category Description of your Product.</small>
                            </div>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
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
<script src="../../js/jquery.slim.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/feather.min.js"></script>
</body>
</html>
