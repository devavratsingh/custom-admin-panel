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
        if(isset($_POST) & !empty($_POST)){
          $name = mysqli_real_escape_string($conn, $_POST['proname']);
          //$urlimg = mysqli_real_escape_string($mysqli, $_POST['imgurl']);
          $description = mysqli_real_escape_string($conn, $_POST['editordata']);
          $categoryid = mysqli_real_escape_string($conn, $_POST['categoryid']);
          date_default_timezone_set("Asia/Kolkata");
          $date = date("Y-m-d H:i:s");
          $lowercase = strtolower($name);
          $url = str_replace(" ", "-", $lowercase);
          $checking = mysqli_query($conn, "SELECT * FROM products WHERE product_name='$name'");
          $rownum = mysqli_num_rows($checking);
          if($rownum > 1) {
             $message = "Product Already Exist.";
          } else {
          $query = "INSERT INTO products (product_name, product_slug, product_category, product_description, userid, created, modified) VALUES ('$name', '$url', '$categoryid', '$description', '$userid', '$date', '$date')";
          $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          if($result){
            $smsm = "Product Added Successfully.";
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
    <meta name="generator" content="SAT SAI INFOCOM">
    <title>Products - MR ART EXPORTS</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <!-- Bootstrap core CSS -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/summernote-bs4.css">
<script type="text/javascript" src="https://daemonite.github.io/material/js/material.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
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
      /* Material design styling */

/*placeholder style*/

.note-placeholder {
  position: absolute;
  top: 20%;
  left: 5%;
  font-size: 2rem;
  color: #e4e5e7;
  pointer-events: none;
}

/*Toolbar panel*/

.note-editor .note-toolbar {
  background: #f0f0f1;
  border-bottom: 1px solid #c2cad8;
  -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.14), 0 3px 4px 0 rgba(0, 0, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
  box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.14), 0 3px 4px 0 rgba(0, 0, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
}

/*Buttons from toolbar*/

.summernote .btn-group, .popover-content .btn-group {
  background: transparent;
  -webkit-box-shadow: none;
  box-shadow: none;
}

.note-popover {
  background: #f0f0f1!important;
}

.summernote .btn, .note-btn {
  color: rgba(0, 0, 0, .54)!important;
  background-color: transparent!important;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.42857;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-box-shadow: none;
  box-shadow: none;
}

.summernote .dropdown-toggle:after {
  vertical-align: middle;
}

.note-editor.card {
  -webkit-box-shadow: none;
  box-shadow: none;
  border-radius: 2px;
}

/* Border of the Summernote textarea */

.note-editor.note-frame {
  border: 1px solid rgba(0, 0, 0, .14);
}

/* Padding of the text in textarea */

.note-editor.note-frame .note-editing-area .note-editable {
  padding-top: 1rem;
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
        <h1 class="display-4">Add Products</h1>
        <form action="" method="POST" autocomplete="off">
          <div class="form-group">
            <label for="categoryInputName">Product Name</label>
            <input type="text" placeholder="Enter Product Name" class="span4 m-wrap form-control" name="proname" required="" aria-describedby="categoryHelp">
            <small id="categoryHelp" class="form-text text-muted">Enter the name of the Product.</small>
          </div>
          <div class="form-group">
            <label for="CategoryOfProduct">Select Category</label>
            <select class="form-control" id="categoryid" name="categoryid">
              <?php $catquery = mysqli_query($conn, "SELECT * FROM categories");  ?>
              <option>Select Category</option>
              <?php while($rescat = mysqli_fetch_assoc($catquery)) { ?>
              <option value="<?php echo $rescat['id']; ?>"><?php echo $rescat['cat_name']; ?></option>
            <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="categoryDescription">Product Description</label>
            <textarea class="span4 m-wrap form-control" aria-descibedby="categorytextareaHelp" id="my-summernote" name="editordata"></textarea>
            <small id="categorytextareaHelp" class="form-text text-muted">Enter the Category Description of your Product.</small>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>

      </div>
      <?php 
      // Display table here 
      ?>
    <div class="col-6 col-md-6 themed-grid-col p-4 shadow-lg">
      <h1 class="display-4">Products List</h1>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Sr. No.</th>
              <th>Name</th>
              <th>Category</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $limit = 10;
            $adjacents = 2;
            $sql = "SELECT COUNT(*) 'total_rows' FROM `products`";
            $res = mysqli_fetch_object(mysqli_query($conn, $sql));
            $total_rows = $res->total_rows;
            $total_pages = ceil($total_rows / $limit);
            $i = 1;
            if(isset($_GET['page']) && !empty($_GET['page'])){
              $page = $_GET['page'];
              $offset = $limit * ($page-1);
              if($page == 1){
                $i=1;
              } else {
                $symba = $page -1;
                $i = $symba * $limit;
              }
            } else {
              $page = 1;
              $i=1;
              $offset = 0;
            }
            $catquery = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC limit $offset, $limit"); 
            
            while($rescat = mysqli_fetch_assoc($catquery)) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $rescat['product_name']; ?></td>
              <td><?php echo $rescat['product_category']; ?></td>
              <td>
                <?php 
                $proid = $rescat['id'];
                $fetchimg = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$proid'");
                $imgget = mysqli_fetch_assoc($fetchimg);
                $count = mysqli_num_rows($fetchimg);
                if($count < 1) {?>
                  <a href="upload-image.php?id=<?php echo $rescat['id']; ?>">
                    <img src="../../images/img-default.png" alt="<?php echo $rescat['product_name']; ?>" class="rounded" width="50px">
                  </a>
                  <?php } else { ?>
                    <a href="upload-image.php?id=<?php echo $rescat['id']; ?>">
                    <img src="<?php echo $imgget['ImagePath']; ?><?php echo $imgget['ImageFileName']; ?>" alt="<?php echo $rescat['product_name']; ?>" class="rounded" width="50px">
                    </a>
                  <?php } ?>
              </td>
              <td>
                <!--<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#editproduct" data-whatever="@edit">Edit</button>
                <a href="delete/deletepro.php?id=<?php echo $rescat['id']; ?>" class="btn btn-primary">Delete</a>-->
                <div class="modal fade" id="editproduct" tabindex="-1" role="form" aria-labelledby="CategoryEditForm" aria-hidden="true">
                  <div class="modal-dialog" role="form">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ExampleModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="categoryInputName"> Name</label>
                              <input type="text" value="<?php echo $rescat['product_name']; ?>" class="span4 m-wrap form-control" name="name" required="" aria-describedby="categoryHelp">
                              <small id="categoryHelp" class="form-text text-muted">Edit the name of the Product.</small>
                            </div>
                            <div class="form-group">
                              <label for="categoryInputName">Image Url</label>
                              <input type="text" value="<?php echo $rescat['cat_image']; ?>" class="span4 m-wrap form-control" name="name" required="" aria-describedby="categoryHelp">
                              <small id="categoryHelp" class="form-text text-muted">Enter the Image URL of your Product in this category.</small>
                            </div>
                            <div class="form-group">
                              <label for="categoryDescription">Product Description</label>
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
        <div class="container-fluid mtb-margin-top">
          <div class="row">
            <div class="col-md-12">
              <?php 
              if($total_pages <= (1+($adjacents *2))) {
                $start = 1;
                $end = $total_pages;
              } else {
                if(($page - $adjacents) > 1){
                  if(($page + $adjacents) < $total_pages){
                    $start = ($page - $adjacents);
                    $end = ($page + $adjacents);
                  } else {
                    $start = ($total_pages - (1+($adjacents*2)));
                    $end = $total_pages;
                  }
                } else {
                  $start = 1;
                  $end = (1 + ($adjacents * 2));
                }
              }
              $start = 1;
              $end = $total_pages;
              if($total_pages > 1) { ?>
                <ul class="pagination pagination-sm justify-content-center">
                  <?php /* Link of the first page */ ?>
                  <li class="page-item <?php ($page <=1 ? print "disabled" : "")?>">
                    <a href="?page=1" class="page-link"><<</a>
                  </li>
                  <?php /* Link of the previous page */ ?>
                  <li class="page-item <?php ($page <=1 ? print "disabled" : "")?>">
                    <a href="?page=<?php ($page>1 ? print($page -1) : print 1)?>" class="page-link"><</a>
                  </li>
                  <?php /* Link for the pages with page number */ ?>
                  <?php for($i=$start; $i <= $end; $i++) { ?>
                  <li class="page-item <?php ($i == $page ? print 'active' : '')?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
                <?php } ?>
                <?php /* Link for the next page */ ?>
                <li class="page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>">
                  <a class="page-link" href="?page=<?php ($page >= $total_pages ? print ($page+1) : print $total_pages)?>">></a>
                </li>
                <?php /* Link of the last page */ ?>
                <li class="page-item <?php ($page >=$total_pages ? print 'disabled' : '') ?>">
                  <a href="?page=<?php echo $total_pages; ?>" class="page-link">>></a>
                </li>
                </ul>
              <?php } ?>
              <?php mysqli_close($conn); ?>
            </div>
          </div>
        </div>
      </div
    </div>
  </div>
    </main>
  </div>
</div>
<script type="text/javascript">
$('#my-summernote').summernote({
  minHeight: 200,
  placeholder: 'Write here ...',
  focus: false,
  airMode: false,
  fontNames: ['Roboto', 'Calibri', 'Times New Roman', 'Arial'],
  fontNamesIgnoreCheck: ['Roboto', 'Calibri'],
  dialogsInBody: true,
  dialogsFade: true,
  disableDragAndDrop: false,
  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['para', ['style', 'ul', 'ol', 'paragraph']],
    ['fontsize', ['fontsize']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['height', ['height']],
    ['misc', ['undo', 'redo', 'print', 'help', 'fullscreen']]
  ],
  popover: {
    air: [
      ['color', ['color']],
      ['font', ['bold', 'underline', 'clear']]
    ]
  },
  print: {
    //'stylesheetUrl': 'url_of_stylesheet_for_printing'
  }
});
$('#my-summernote2').summernote({airMode: true,placeholder:'Try the airmode'});

</script>
<script src="../../js/jquery.slim.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/feather.min.js"></script>
</body>
</html>
