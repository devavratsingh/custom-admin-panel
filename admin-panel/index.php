<?php
session_start();
require("app/config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: sign-in.php");
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
    <title>Dashboard - MR ART EXPORTS</title>
    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">


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
    <link href="css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><img src="../images/logo.png" width="100px"></a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="sign-out.php">Sign out</a>
        </li>
      </ul>
    </nav>

<div class="container-fluid">
  <div class="row">
    <?php include("navigation/main-navigation.php"); ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="display-2">Dashboard</h1>
        
      </div>

      <h2>Products</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Sr. No.</th>
              <th>Name</th>
              <th>Category</th>
              <th>Image</th>
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
              <td style="text-align: center;"><?php echo $i; ?></td>
              <td><?php echo $rescat['product_name']; ?></td>
              <td><?php echo $rescat['product_category']; ?></td>
              <td>
                <?php 
                $proid = $rescat['id'];
                $fetchimg = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$proid'");
                $imgget = mysqli_fetch_assoc($fetchimg);
                $count = mysqli_num_rows($fetchimg);
                if($count < 1) {?>
                  <a href="app/upload-image.php?id=<?php echo $rescat['id']; ?>">
                    <img src="../images/img-default.png" alt="<?php echo $rescat['product_name']; ?>" class="rounded" width="50px">
                  </a>
                  <?php } else { ?>
                    <a href="app/upload-image.php?id=<?php echo $rescat['id']; ?>">
                    <img src="app/<?php echo $imgget['ImagePath']; ?><?php echo $imgget['ImageFileName']; ?>" alt="<?php echo $rescat['product_name']; ?>" class="rounded" width="50px">
                    </a>
                  <?php } ?>
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
      </div>
    </main>
  </div>
</div>
<script src="../js/jquery.slim.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/feather.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/dashboard.js"></script></body>
</html>
