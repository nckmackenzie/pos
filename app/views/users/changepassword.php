<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card bg-light">
                    <div class="card-header bg-secondary">Change Password</div>
                    <div class="card-body">
                        <form action="<?php echo URLROOT;?>/users/password" method="post">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="password" name="old" id="old" 
                                               class="form-control form-control-sm mandatory
                                               <?php echo (!empty($data['old_err'])) ? 'is-invalid' : ''?>"
                                               value="<?php echo $data['old'];?>"
                                               placeholder="Enter Old Password">
                                        <span class="invalid-feedback"><?php echo $data['old_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="password" name="new" id="new" 
                                               class="form-control form-control-sm mandatory
                                               <?php echo (!empty($data['new_err'])) ? 'is-invalid' : ''?>"
                                               value="<?php echo $data['new'];?>"
                                               placeholder="Enter New Password">
                                        <span class="invalid-feedback"><?php echo $data['new_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="password" name="confirm" id="confirm" 
                                               class="form-control form-control-sm mandatory
                                               <?php echo (!empty($data['confirm_err'])) ? 'is-invalid' : ''?>"
                                               value="<?php echo $data['confirm'];?>"
                                               placeholder="Confirm Password">
                                        <span class="invalid-feedback"><?php echo $data['confirm_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <button type="submit" class="btn btn-sm bg-custom btn-block text-white">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
</body>
</html>  