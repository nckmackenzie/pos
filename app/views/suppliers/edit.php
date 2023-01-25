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
            <a href="<?php echo URLROOT;?>/suppliers" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row col-md-8 mx-auto">
            <div class="card bg-light">
                <div class="card-header bg-secondary">Edit Supplier</div>
                <div class="card-body">
                    <form action="<?php echo URLROOT;?>/suppliers/update" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Supplier Name</label>
                                    <input type="text" name="name" 
                                           class="form-control form-control-sm mandatory
                                           <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''?>"
                                           value="<?php echo (!empty($data['name'])) ? $data['name'] : strtoupper($data['supplier']->SupplierName) ?>" autocomplete="off">
                                    <span class="invalid-feedback"><?php echo $data['name_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" name="contact" 
                                           class="form-control form-control-sm mandatory
                                           <?php echo (!empty($data['contact_err'])) ? 'is-invalid' : ''?>"
                                           value="<?php echo (!empty($data['contact'])) ? $data['contact'] : $data['supplier']->Contact ?>" autocomplete="off">
                                    <span class="invalid-feedback"><?php echo $data['contact_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" 
                                           class="form-control form-control-sm"
                                           value="<?php echo strtoupper($data['supplier']->Address); ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" 
                                           class="form-control form-control-sm"
                                           value="<?php echo $data['supplier']->Email;?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pin">PIN</label>
                                    <input type="text" name="pin" 
                                           class="form-control form-control-sm"
                                           value="<?php echo $data['supplier']->PIN;?>" 
                                           oninput="this.value = this.value.toUpperCase()"
                                           autocomplete="off"
                                           maxlength="11">   
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <input type="hidden" name="id" value="<?php echo $data['supplier']->ID;?>">
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