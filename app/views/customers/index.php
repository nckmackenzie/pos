<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
<!-- Modal -->
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/customers/delete" method="post">
              <div class="row">
                <div class="col-md-9">
                  <label for="">Delete Selected Customer?</label>
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
        <?php flash('customer_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/customers/add" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="customersTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>PIN</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['customers'] as $customer) :?>
                            <tr>
                                <td><?php echo $customer->ID;?></td>
                                <td><?php echo strtoupper($customer->CustomerName);?></td>
                                <td><?php echo $customer->Contact;?></td>
                                <td><?php echo $customer->Email;?></td>
                                <td><?php echo strtoupper($customer->PIN);?></td>
                                <?php if($customer->Active == 1) :?>
                                    <td><span class="badge badge-pill badge-success">Active</span></td>
                                <?php else : ?>
                                    <td><span class="badge badge-pill badge-danger">Inactive</span></td>
                                <?php endif; ?>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo URLROOT;?>/customers/edit/<?php echo $customer->ID;?>" class="btn btn-sm bg-olive custom-font">Edit</a>
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
      $('#customersTable').DataTable({
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "10%" , "targets": 2},
            {"width" : "20%" , "targets": 3},
            {"width" : "10%" , "targets": 4},
            {"width" : "10%" , "targets": 5},
            {"width" : "15%" , "targets": 6},
        ],
        'responsive' : true
      });

      $('#customersTable').on('click','.btndel',function(){
          $('#deleteModalCenter').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
         
          var currentRow = $(this).closest("tr");
          var data1 = $('#customersTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
    });
</script>
</body>
</html>