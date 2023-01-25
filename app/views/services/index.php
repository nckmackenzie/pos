<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
<!-- Modal -->
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/services/delete" method="post">
              <div class="row">
                <div class="col-md-9">
                  <label for="">Delete Selected Service?</label>
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
        <?php flash('service_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/services/add" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="servicesTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>Service Date</th>
                            <th>Service Type</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <?php if($_SESSION['utype'] == 1) : ?>
                            <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['services'] as $service) : ?>
                            <tr>
                              <td><?php echo $service->ID;?></td>
                              <td><?php echo $service->ServiceDate;?></td>
                              <td><?php echo $service->ServiceType;?></td>
                              <td><?php echo $service->Customer;?></td>
                              <td><?php echo number_format($service->Amount,2);?></td>
                              <?php if($_SESSION['utype'] == 1) : ?>
                              <td>
                                  <div class="btn-group">
                                    <a href="<?php echo URLROOT;?>/services/edit/<?php echo $service->ID;?>" class="btn btn-sm bg-olive custom-font">
                                      <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger custom-font btndel"><i class="bi bi-trash"></i></button>
                                  </div>
                              </td>
                            </tr>
                            <?php endif; ?>
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
      $('#servicesTable').DataTable({
        'ordering' : false,
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "10%" , "targets": 1},
            {"width" : "15%" , "targets": 4}
            <?php if($_SESSION['utype'] == 1) : ?>
            ,{"width" : "10%" , "targets": 5},
            <?php endif; ?>
        ],
        'responsive' : true
      });

      $('#servicesTable').on('click','.btndel',function(){
          $('#deleteModalCenter').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
         
          var currentRow = $(this).closest("tr");
          var data1 = $('#servicesTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
    });
</script>
</body>
</html>