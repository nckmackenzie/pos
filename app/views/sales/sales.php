<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topNav.php';?>
<?php require APPROOT . '/views/inc/sideNav.php';?>
<!-- Modal -->
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Sale</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/sales/delete" method="post">
              <div class="row">
                <div class="col-md-9">
                  <label for="">Delete Selected Sale?</label>
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
        <?php flash('sale_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/sales" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="salesTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>Sale ID</th>
                            <th>Sales Date</th>
                            <th>Customer</th>
                            <th>Sale Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['sales'] as $sale) :?>
                            <tr>
                                <td><?php echo $sale->ID;?></td>
                                <td><?php echo $sale->SalesID;?></td>
                                <td><?php echo $sale->SaleDate;?></td>
                                <td><?php echo $sale->CustomerName;?></td>
                                <td><?php echo number_format($sale->SaleValue,2);?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo URLROOT;?>/sales/print/<?php echo $sale->ID;?>" target="_blank" class="btn btn-sm btn-warning custom-font">Print</a>
                                        <?php if($_SESSION['utype'] == 1 && $sale->AmountPaid == 0) : ?>
                                            <a href="<?php echo URLROOT;?>/sales/edit/<?php echo $sale->ID;?>" class="btn btn-sm bg-olive custom-font">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger custom-font btndel">Delete</button>
                                        <?php endif; ?>
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
      $('#salesTable').DataTable({
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "10%" , "targets": 1},
            {"width" : "15%" , "targets": 2},
            {"width" : "15%" , "targets": 5},
        ],
        'responsive' : true,
        'ordering' : false
      });

      $('#salesTable').on('click','.btndel',function(){
          $('#deleteModalCenter').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
         
          var currentRow = $(this).closest("tr");
          var data1 = $('#salesTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
    });
</script>
</body>
</html>