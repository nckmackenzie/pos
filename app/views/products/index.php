<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
<!-- Modal -->
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/products/delete" method="post">
              <div class="row">
                <div class="col-md-9">
                  <label for="">Delete Selected Product?</label>
                  <input type="hidden" name="id" id="id">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </div>
          </form>
      </div>
     
    </div>
  </div>
</div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <?php flash('product_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/products/add" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="productsTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Buying Price</th>
                            <th>Selling Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['products'] as $product) :?>
                            <tr>
                                <td><?php echo $product->ID;?></td>
                                <td><?php echo $product->ProductName;?></td>
                                <td><?php echo $product->Category;?></td>
                                <td><?php echo $product->BuyingPrice;?></td>
                                <td><?php echo $product->SellingPrice;?></td>
                                
                                <?php if($product->CurrentStock < 10) : ?>
                                    <td>
                                      <span class="badge badge-danger">
                                        <?php echo number_format($product->CurrentStock,2); ?>
                                      </span>
                                    </td>
                                <?php elseif($product->CurrentStock < 20) : ?>
                                    <td>
                                      <span class="badge badge-warning">
                                        <?php echo number_format($product->CurrentStock,2); ?>
                                      </span>
                                    </td>
                                <?php else : ?>
                                    <td>
                                      <span class="badge badge-success">
                                        <?php echo number_format($product->CurrentStock,2); ?>
                                      </span>
                                    </td>
                                <?php endif; ?>  
                                <?php if($product->Active == 1) :?>
                                    <td><span class="badge badge-pill badge-success">Active</span></td>
                                <?php else : ?>
                                    <td><span class="badge badge-pill badge-danger">Active</span></td>
                                <?php endif; ?>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo URLROOT;?>/products/edit/<?php echo $product->ID;?>" class="btn btn-sm bg-olive custom-font">Edit</a>
                                          <button type="button" class="btn btn-sm btn-danger custom-font btndel">Delete</button>
                                    </div>
                                  </td>     
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>    
        </div>        
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php require APPROOT . '/views/inc/footer.php'?>
<script>
    $(function(){
      $('#productsTable').DataTable({
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "15%" , "targets": 2},
            {"width" : "10%" , "targets": 3},
            {"width" : "10%" , "targets": 4},
            {"width" : "10%" , "targets": 5},
            {"width" : "10%" , "targets": 6},
            {"width" : "15%" , "targets": 7},
        ],
        'responsive' : true
      });

      $('#productsTable').on('click','.btndel',function(){
          $('#deleteModalCenter').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
         
          var currentRow = $(this).closest("tr");
          var data1 = $('#productsTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
    });
</script>
</body>
</html>