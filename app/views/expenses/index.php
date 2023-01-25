<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
<!-- Modal -->
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Expense</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/expenses/delete" method="post">
              <div class="row">
                <div class="col-md-9">
                  <label for="">Delete Selected Expense?</label>
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
        <?php flash('expense_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/expenses/add" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="expensesTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>Expense Date</th>
                            <th>Expense Description</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['expenses'] as $expense) :?>
                            <tr>
                                <td><?php echo $expense->ID;?></td>
                                <td><?php echo $expense->ExpenseDate;?></td>
                                <td><?php echo strtoupper($expense->Description);?></td>
                                <td><?php echo number_format($expense->Amount,2);?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo URLROOT;?>/expenses/edit/<?php echo $expense->ID;?>"
                                           class="btn btn-sm bg-olive custom-font">Edit</a>
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
      $('#expensesTable').DataTable({
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "15%" , "targets": 1},
            {"width" : "20%" , "targets": 3},
            {"width" : "15%" , "targets": 4},
        ],
        'responsive' : true,
        'ordering' : false
      });

      $('#expensesTable').on('click','.btndel',function(){
          $('#deleteModalCenter').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
         
          var currentRow = $(this).closest("tr");
          var data1 = $('#expensesTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
    });
</script>
</body>
</html>