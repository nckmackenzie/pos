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
            <a href="<?php echo URLROOT;?>/customers" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row col-md-8 mx-auto">
            <div class="card bg-light">
                <div class="card-header bg-secondary">Add Customer</div>
                <div class="card-body">
                    <form action="<?php echo URLROOT;?>/customers/create" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <input type="text" name="name" 
                                           class="form-control form-control-sm mandatory
                                           <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''?>"
                                           value="<?php echo $data['name'];?>" autocomplete="off">
                                    <span class="invalid-feedback"><?php echo $data['name_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" name="contact" 
                                           class="form-control form-control-sm mandatory
                                           <?php echo (!empty($data['contact_err'])) ? 'is-invalid' : ''?>"
                                           value="<?php echo $data['contact'];?>" autocomplete="off" maxlength="10">
                                    <span class="invalid-feedback"><?php echo $data['contact_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" 
                                           class="form-control form-control-sm"
                                           value="<?php echo $data['address'];?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" 
                                           class="form-control form-control-sm"
                                           value="<?php echo $data['email'];?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pin">PIN</label>
                                    <input type="text" name="pin" 
                                           class="form-control form-control-sm"
                                           value="<?php echo $data['pin'];?>" 
                                           oninput="this.value = this.value.toUpperCase()"
                                           autocomplete="off"
                                           maxlength="11">   
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="openingbal">Opening Balance</label>
                                    <input type="number" name="openingbal" id="openingbal" 
                                           class="form-control form-control-sm"
                                           value="<?php echo $data['openingbal'];?>">
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
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
</body>
</html>  