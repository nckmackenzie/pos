<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topNav.php';?>
<?php require APPROOT . '/views/inc/sideNav.php';?>
<!-- Modal -->
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/suppliers/delete" method="post">
              <div class="row">
                <div class="col-md-9">
                  <label for="">Delete Selected Supplier?</label>
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
        <?php flash('receipt_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/receipts/add" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="receiptsTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>Receipt Ref</th>
                            <th>Receipt Date</th>
                            <th>Supplier</th>
                            <th>Receipt Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['receipts'] as $receipt) : ?>
                            <tr>
                              <td><?php echo $receipt->ID;?></td>
                              <td><?php echo $receipt->Reference;?></td>
                              <td><?php echo $receipt->ReceiptDate;?></td>
                              <td><?php echo $receipt->Supplier;?></td>
                              <td><?php echo number_format($receipt->rvalue,2);?></td>
                              <td>
                                  <div class="btn-group">
                                    <a href="<?php echo URLROOT;?>/receipts/edit/<?php echo $receipt->ID;?>" class="btn btn-sm bg-olive custom-font">
                                      <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger custom-font btndel"><i class="bi bi-trash"></i></button>
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
      $('#receiptsTable').DataTable({
        'ordering' : false,
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "10%" , "targets": 1},
            {"width" : "15%" , "targets": 2},
            {"width" : "15%" , "targets": 4},
            {"width" : "10%" , "targets": 5},
        ],
        'responsive' : true
      });

      $('#receiptsTable').on('click','.btndel',function(){
          $('#deleteModalCenter').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
         
          var currentRow = $(this).closest("tr");
          var data1 = $('#receiptsTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
    });
</script>
</body>
</html>