<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topNav.php';?>
<?php require APPROOT . '/views/inc/sideNav.php';?>
<!--Deact Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deactivate Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/categories/deactivate" method="post">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Deactivate Category?</label>
                  <input type="hidden" name="id" id="id">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-warning">Deactivate</button>
            </div>
          </form>
      </div>
      </div>
  </div>
</div>
<!--Act Modal -->
<div class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actModalLabel">Activate Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/categories/activate" method="post">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Activate Category?</label>
                  <input type="hidden" name="id" id="idact">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info">Activate</button>
            </div>
          </form>
      </div>
      </div>
  </div>
</div>
<!--Del Modal -->
<div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delModalLabel">Delete Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo URLROOT;?>/categories/delete" method="post">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Delete Category?</label>
                  <input type="hidden" name="id" id="iddel">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Delete</button>
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
        <?php flash('category_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/categories/add" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="categoriesTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['categories'] as $category) :?>
                            <tr>
                                <td><?php echo $category->ID;?></td>
                                <td><?php echo strtoupper($category->CategoryName);?></td>
                                <?php if($category->Active == 1) :?>
                                    <td><span class="badge badge-pill badge-success">Active</span></td>
                                <?php else : ?>
                                    <td><span class="badge badge-pill badge-danger">Inactive</span></td>
                                <?php endif; ?>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo URLROOT;?>/categories/edit/<?php echo $category->ID;?>" class="btn btn-sm bg-olive">Edit</a>
                                        <?php if($category->Active == 1) : ?>
                                          <button type="button" class="btn btn-sm btn-warning btndea">Deactivate</button>
                                        <?php else : ?>
                                          <button type="button" class="btn btn-sm btn-info btnact">Activate</button>  
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-danger btndel">Delete</button>
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
      $('#categoriesTable').DataTable({
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "10%" , "targets": 2},
            {"width" : "20%" , "targets": 3},
        ],
        'responsive' : true
      });

      $('#categoriesTable').on('click','.btndea',function(){
          $('#deactivateModal').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
          
          var currentRow = $(this).closest("tr");
          var data1 = $('#categoriesTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
      $('#categoriesTable').on('click','.btnact',function(){
          $('#activateModal').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
          
          var currentRow = $(this).closest("tr");
          var data1 = $('#categoriesTable').DataTable().row(currentRow).data();
          $('#idact').val(data1[0]);
      });
      $('#categoriesTable').on('click','.btndel',function(){
          $('#delModal').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
          
          var currentRow = $(this).closest("tr");
          var data1 = $('#categoriesTable').DataTable().row(currentRow).data();
          $('#iddel').val(data1[0]);
      });
    });
</script>
</body>
</html>