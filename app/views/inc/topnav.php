<body class="hold-transition sidebar-mini text-sm">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
              ><i class="fas fa-bars"></i
            ></a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <div class="d-flex align-items-center">
                <i class="fas fa-user mr-2"></i>
                <h4 class="text-sm m-0 mr-2"><?php echo strtoupper($_SESSION['usid']);?></h4>
                <i class="fas fa-caret-down"></i>
              </div>
              <!-- <i class="fas fa-user"></i>
              <h4 class="text-sm">Admin</h4> -->
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-header"><?php echo strtoupper($_SESSION['uname']);?></span>
              <div class="dropdown-divider"></div>
              <a href="<?php echo URLROOT;?>/users/changepassword" class="dropdown-item">
                <i class="fas fa-lock mr-2"></i> Change Password
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo URLROOT;?>/users/logout" class="dropdown-item">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->