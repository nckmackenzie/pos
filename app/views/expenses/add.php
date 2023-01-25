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
          <a href="<?php echo URLROOT;?>/expenses" class="btn btn-dark btn-sm mt-2">
             <i class="bi bi-arrow-left"></i> Back
          </a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card bg-light">
                    <div class="card-header bg-secondary">Add Expense</div>
                    <div class="card-body">
                        <form action="<?php echo URLROOT;?>/expenses/create" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="date">Expense Date</label>
                                    <input type="date" name="date" id="date" 
                                       class="form-control form-control-sm mandatory
                                       <?php echo (!empty($data['date_err'])) ? 'is-invalid' : ''?>"
                                       value="<?php echo !empty($data['date']) ? $data['date'] : date('Y-m-d') ?>">
                                    <span class="invalid-feedback"><?php echo $data['date_err'];?></span>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="amount">Expense Amount</label>
                                    <input type="number" name="amount" id="amount" 
                                       class="form-control form-control-sm mandatory
                                       <?php echo (!empty($data['amount_err'])) ? 'is-invalid' : ''?>"
                                       value="<?php echo $data['amount'];?>">
                                    <span class="invalid-feedback"><?php echo $data['amount_err'];?></span>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="desc">Description</label>
                                    <input type="text" name="desc" id="desc" 
                                           class="form-control form-control-sm mandatory
                                           <?php echo (!empty($data['desc_err'])) ? 'is-invalid' :''?>"
                                           value="<?php echo $data['desc'];?>"
                                           placeholder="eg Water Bill,Salary,Rent">
                                    <span class="invalid-feedback"><?php echo $data['desc_err'];?></span>
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