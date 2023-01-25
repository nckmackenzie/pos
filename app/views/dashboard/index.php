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
            <h1>Dashboard</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box gradient gradient-1">
                    <div class="inner">
                      <h3 id="custom-title"><?php echo $data['header']->ProductCount;?></h3>
                      <p>Products Sold</p>
                    </div>
                    <div class="icon"><i class="ion bi bi-handbag"></i></div>
                  </div>
                </div><!--</col-->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box gradient gradient-2">
                    <div class="inner">
                      <h3 id="custom-title"><?php echo number_format($data['header']->SalesValue);?></h3>
                      <p>Sales Value</p>
                    </div>
                    <div class="icon"><i class="ion bi bi-currency-dollar"></i></div>
                  </div>
                </div><!--</col-->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box gradient gradient-3">
                    <div class="inner">
                      <h3 id="custom-title"><?php echo number_format($data['header']->TotalExpenses);?></h3>
                      <p>Total Expenses</p>
                    </div>
                    <div class="icon"><i class="ion bi bi-calculator"></i></div>
                  </div>
                </div><!--</col-->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box gradient gradient-4">
                    <div class="inner">
                      <h3 id="custom-title"><?php echo number_format($data['header']->Balances);?></h3>
                      <p>Unpaid Sales Value</p>
                    </div>
                    <div class="icon"><i class="ion bi bi-battery-half"></i></div>
                  </div>
                </div><!--</col-->
            </div><!-- </row -->
            <div class="row">
              <div class="col-lg-9">
                  <div class="card">
                    <div class="card-header border-transparent gradient-1">
                       <h3 class="card-title text-white">Latest Sales</h3>
                    </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table m-0">
                            <thead>
                              <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Value</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($data['products'] as $product) : ?>
                                  <tr>
                                    <td><?php echo $product->ProductName;?></td>
                                    <td><?php echo $product->Qty;?></td>
                                    <td><?php echo number_format($product->SellingValue,2);?></td>
                                  </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                         </div>
                      </div>
                  </div>
              </div><!--</col> -->
              <div class="col-lg-3">
                <div class="card">
                  <div class="card-header border-transparent gradient-1">
                    <h3 class="card-title text-white">Top Customers</h3>
                  </div>
                  <div class="card-body p-0">
                    <ul class="list-group">
                      <?php foreach($data['customers'] as $customer) : ?>
                        <li class="list-group-item"><?php echo $customer->CustomerName;?> 
                          <span class="badge badge-warning float-right">
                            <?php echo number_format($customer->TotalAmount);?>
                          </span>
                        </li>
                      <?php endforeach; ?>   
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </div><!-- </container fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
</body>
</html>  