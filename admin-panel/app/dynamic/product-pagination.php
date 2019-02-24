<?php
require("../config/database.php");
 
$limit = 2;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
  
$sql = "SELECT * FROM products ORDER BY id ASC LIMIT $start_from, $limit";  
$rs_result = mysqli_query($conn, $sql);  
?> 
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
            $i = 1;
            while ($row = mysql_fetch_assoc($rs_result)) {   ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['product_category']; ?></td>
              <td>
                <?php 
                $proid = $row['id'];
                $fetchimg = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$proid'");
                $imgget = mysqli_fetch_assoc($fetchimg);
                $count = mysqli_num_rows($fetchimg);
                if($count < 1) {?>
                  <a href="upload-image.php?id=<?php echo $row['id']; ?>">
                    <img src="../../images/img-default.png" alt="<?php echo $row['product_name']; ?>" class="rounded" width="50px">
                  </a>
                  <?php } else { ?>
                    <a href="upload-image.php?id=<?php echo $rescat['id']; ?>">
                    <img src="<?php echo $imgget['ImagePath']; ?><?php echo $imgget['ImageFileName']; ?>" alt="<?php echo $row['product_name']; ?>" class="rounded" width="50px">
                    </a>
                  <?php } ?>
              </td>
              <td>
                <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#editproduct" data-whatever="@edit">Edit</button>
                <a href="delete/deletepro.php?id=<?php echo $rescat['id']; ?>" class="btn btn-primary">Delete</a>
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
          <div>
        </table>