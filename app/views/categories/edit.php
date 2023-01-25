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
            <a href="<?php echo URLROOT;?>/categories" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <form action="<?php echo URLROOT;?>/categories/update" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control form-control-sm mandatory
                            <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''?>"
                            value="<?php echo empty($data['name_err']) ? strtoupper($data['category']->CategoryName) : $data['name']?>">
                        <span class="invalid-feedback"><?php echo $data['name_err'];?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    <button type="submit" class="btn btn-sm btn-block bg-custom text-white">Save</button>
                    <input type="hidden" name="id" value="<?php echo $data['category']->ID;?>">
                </div>
            </div>
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
</body>
</html>  