<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4"
       style="background-color: #254565;">
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light d-block text-center text-lg">McPOS</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img
                src="<?php echo URLROOT;?>/dist/img/user3.png"
                class="img-circle elevation-2"
                alt="User Image"
              />
            </div>
            <div class="info">
              <a href="#" class="d-block"><?php echo ucwords($_SESSION['uname']);?></a>
            </div>
        </div>
          <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
              data-accordion="false">
              <li class="nav-item">
                <a href="<?php echo URLROOT;?>/dashboard" class="nav-link">
                  <i class="nav-icon bi bi-speedometer2"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <?php if($_SESSION['utype'] == 1) : ?>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-code-square"></i>
                  <p>
                    Admin
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/users/all" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Users</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/companies/edit/<?php echo $_SESSION['cid'];?>" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Company</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/suppliers" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Suppliers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/customers" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Customers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/categories" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Categories</p>
                    </a>
                  </li>
                </ul>
              </li>
              <?php endif;?>
              <li class="nav-item">
                <a href="<?php echo URLROOT;?>/products" class="nav-link">
                  <i class="nav-icon bi bi-bag"></i>
                  <p>Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo URLROOT;?>/receipts" class="nav-link">
                  <i class="nav-icon bi bi-cart"></i>
                  <p>Receipts</p>
                </a>
              </li>             
              <li class="nav-item">
                <a href="<?php echo URLROOT;?>/sales" class="nav-link">
                  <i class="nav-icon bi bi-currency-dollar"></i>
                  <p>Sale</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo URLROOT;?>/services" class="nav-link">
                  <i class="nav-icon bi bi-hammer"></i>
                  <p>Services</p>
                </a>
              </li>
              <?php if($_SESSION['utype'] == 1) : ?>
              <li class="nav-item">
                <a href="<?php echo URLROOT;?>/payments" class="nav-link">
                  <i class="nav-icon bi bi-wallet2"></i>
                  <p>Payments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo URLROOT;?>/expenses" class="nav-link">
                  <i class="nav-icon bi bi-calculator"></i>
                  <p>Expenses</p>
                </a>
              </li>
              <?php endif;?>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-file-bar-graph"></i>
                  <p>
                    Reports
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/reports/stock" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Stock Report</p>
                    </a>
                  </li>
                  <?php if($_SESSION['utype'] == 1) : ?>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/reports/incomestatement" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Income Statement</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/reports/statement" class="nav-link sub">
                      <i class="fas fa-chevron-right"></i>
                      <p class="ml-2">Customer Statement</p>
                    </a>
                  </li>
                  <?php endif; ?>
                </ul>
              </li>
            </ul>
        </nav>
          <!-- /.sidebar-menu -->
    </div>
        <!-- /.sidebar -->
</aside>