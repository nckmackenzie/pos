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
            <a href="<?php echo URLROOT;?>/products" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card bg-light">
                    <div class="card-header bg-secondary">Edit Product</div>
                    <div class="card-body">
                        <form action="<?php echo URLROOT;?>/products/update" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" id="name"
                                               class="form-control form-control-sm mandatory
                                               <?php echo (!empty($data['name_err'])) ? 'is-invalid' :''?>"
                                               value="<?php echo (!empty($data['name'])) ? $data['name'] : strtoupper($data['product']->ProductName)?>"
                                               autocomplete="off">
                                        <span class="invalid-feedback"><?php echo $data['name_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category" id="category" 
                                                class="form-control form-control-sm mandatory
                                                <?php echo (!empty($data['category_err'])) ? 'is-invalid' : ''?>">
                                            <?php foreach($data['categories'] as $category) : ;?>
                                                <option value="<?php echo $category->ID;?>" <?php selectdCheckEdit($data['category'],$data['product']->CategoryID,$category->ID)?>>
                                                    <?php echo $category->CategoryName;?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="invalid-feedback"><?php echo $data['category_err'];?></span>
                                    </div>
                                </div>
                                <?php if($data['isinitial']) : ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bal">Opening Balance</label>
                                            <input type="number" name="bal" id="bal"
                                                class="form-control form-control-sm mandatory
                                                <?php echo (!empty($data['bal_err'])) ? 'is-invalid' : ''?>"
                                                value="<?php echo $data['bal'];?>"
                                                autocomplete="off">
                                            <span class="invalid-feedback"><?php echo $data['bal_err'];?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="<?php echo $data['isinitial'] ? 'col-md-4' : 'col-md-6' ?>">
                                    <div class="form-group">
                                        <label for="bp">Buying Price</label>
                                        <input type="number" name="bp" id="bp"
                                               class="form-control form-control-sm mandatory
                                               <?php echo (!empty($data['bp_err'])) ? 'is-invalid' : ''?>"
                                               value="<?php echo (!empty($data['bp'])) ? $data['bp'] : $data['product']->BuyingPrice ?>"
                                               autocomplete="off">
                                        <span class="invalid-feedback"><?php echo $data['bp_err'];?></span>
                                    </div>
                                </div>
                                <div class="<?php echo $data['isinitial'] ? 'col-md-4' : 'col-md-6' ?>">
                                    <div class="form-group">
                                        <label for="sp">Selling Price</label>
                                        <input type="number" name="sp" id="sp"
                                               class="form-control form-control-sm mandatory
                                               <?php echo (!empty($data['sp_err'])) ? 'is-invalid' : ''?>"
                                               value="<?php echo (!empty($data['sp'])) ? $data['sp'] : $data['product']->SellingPrice ?>"
                                               autocomplete="off">
                                        <span class="invalid-feedback"><?php echo $data['sp_err'];?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea name="description" id="description" 
                                                  cols="30" rows="5" class="form-control form-control-sm"><?php echo (!empty($data['description'])) ? $data['description'] : $data['product']->Description ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                <input type="hidden" name="id" value="<?php echo $data['product']->ID;?>">
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