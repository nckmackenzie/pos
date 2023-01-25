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
            <a href="<?php echo URLROOT;?>/users/all" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card bg-light">
                    <div class="card-header">Add User</div>
                    <div class="card-body">
                        <form action="<?php echo URLROOT;?>/users/create" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userid">User ID</label>
                                        <input type="text" name="userid" id="userid"
                                        class="form-control form-control-sm mandatory
                                        <?php echo (!empty($data['userid_err'])) ? 'is-invalid' : ''?>"
                                        value="<?php echo $data['userid'];?>"
                                        autocomplete="off">
                                        <span class="invalid-feedback"><?php echo $data['userid_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">User Name</label>
                                        <input type="text" name="name" id="name"
                                        class="form-control form-control-sm mandatory
                                        <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''?>"
                                        value="<?php echo $data['name'];?>"
                                        autocomplete="off">
                                        <span class="invalid-feedback"><?php echo $data['name_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password"
                                        class="form-control form-control-sm mandatory
                                        <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''?>"
                                        value="<?php echo $data['password'];?>">
                                        <span class="invalid-feedback"><?php echo $data['password_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">User Type</label>
                                        <select name="type" id="type" class="form-control form-control-sm">
                                            <option value="1" <?php selectdCheck($data['type'],1) ?>>Admin</option>
                                            <option value="2" <?php selectdCheck($data['type'],2) ?>>Standard User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <button type="submit" class="btn btn-sm btn-block bg-custom text-white">Save</button>
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