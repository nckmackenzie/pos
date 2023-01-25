<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <?php flash('user_msg');?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="<?php echo URLROOT;?>/users/add" class="btn btn-sm bg-custom text-white">Add New</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-sm" id="usersTable">
                    <thead class="bg-navy">
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['users'] as $user) :?>
                            <tr>
                                <td><?php echo $user->ID;?></td>
                                <td><?php echo $user->UserID;?></td>
                                <td><?php echo $user->UserName;?></td>
                                <td><?php echo $user->UserType;?></td>
                                <?php if($user->Active == 1) :?>
                                    <td><span class="badge badge-pill badge-success">Active</span></td>
                                <?php else : ?>
                                    <td><span class="badge badge-pill badge-danger">Active</span></td>
                                <?php endif; ?>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo URLROOT;?>/banks/edit/<?php echo $user->ID;?>" class="btn btn-sm bg-olive custom-font">Edit</a>
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
      $('#usersTable').DataTable({
        'columnDefs' : [
            {"visible" : false, "targets": 0},
            {"width" : "15%" , "targets": 3},
            {"width" : "10%" , "targets": 4},
            {"width" : "15%" , "targets": 5},
        ],
        'responsive' : true
      });

      $('#usersTable').on('click','.btndel',function(){
          $('#deleteModalCenter').modal('show');
          $tr = $(this).closest('tr');

          let data = $tr.children('td').map(function(){
              return $(this).text();
          }).get();
          $('#bankname').val(data[0]);
          var currentRow = $(this).closest("tr");
          var data1 = $('#usersTable').DataTable().row(currentRow).data();
          $('#id').val(data1[0]);
      });
    });
</script>
</body>
</html>