<!-- Side navigation -->
<div class="sidenav">
  <div class="d-flex align-items-center pt-2">
    <h4 class="mt-1 px-2 text-white text-uppercase">System</h4>
  </div>
  <hr class="hr-sidenav">

  <?php if ($_SESSION['user_info']['role'] == 1 || $_SESSION['user_info']['role'] == 2) { ?>
    <a href="index.php" class="nav-link d-flex align-items-center">
      <i class="fa-solid fa-gauge"></i>
      <p class="my-2 px-2">Dashboard</p>
      <?php if (getStatusCount('PENDING') != 0) { ?>
        <span class="bg-warning rounded-circle px-2 text-white fw-bold mx-1"><?= getStatusCount('PENDING'); ?></span>
      <?php } ?>
    </a>
  <?php } ?>

  <?php if ($_SESSION['user_info']['role'] != 1) { ?>
    <a href="user-attendance.php" class="nav-link d-flex align-items-center">
      <i class="fa-solid fa-clipboard-user"></i>
      <p class="my-2 px-2">Daily Attendance</p>
    </a>
  <?php } ?>

  <!-- track -->
  <a href="#" id="trackButton" class="nav-link  d-flex align-items-center">
    <i class="fa-solid fa-truck-ramp-box"></i>
    <p class="my-2 px-2">Tracking</p>
    <i class="fa-solid fa-chevron-down" style="margin-left:auto! important;"></i>
  </a>
  <div id="trackAccordion" class="cs-accordion-body">
    <ul class="list-unstyled">
      <li>
        <a href="track.php">Track</a>
      </li>
      <li>
        <a href="deliver.php">Deliver</a>
      </li>
      <li>
        <a href="listOfCompleted.php">Completed</a>
      </li>
    </ul>
  </div>

  <?php if ($_SESSION['user_info']['role'] == 1 || $_SESSION['user_info']['role'] == 2) { ?>
    <!-- order -->
    <a href="#" id="orderButton" class="nav-link d-flex align-items-center">
      <i class="fa-solid fa-boxes"></i>
      <p class="my-2 px-2">Orders</p>
      <i class="fa-solid fa-chevron-down" style="margin-left:auto! important;"></i>
    </a>
    <div id="orderAccordion" class="cs-accordion-body">
      <ul class="list-unstyled">
        <li>
          <a href="orders.php">Order List</a>
        </li>

        <?php if ($_SESSION['user_info']['role'] == 1) { ?>
          <li>
            <a href="products.php">Products</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  <?php } ?>

  <?php if ($_SESSION['user_info']['role'] == 1) { ?>
    <!-- order -->
    <a href="#" id="userButton" class="nav-link d-flex align-items-center">
      <i class="fa-solid fa-users"></i>
      <p class="my-2 px-2">Users</p>
      <i class="fa-solid fa-chevron-down" style="margin-left:auto! important;"></i>
    </a>
    <div id="userAccordion" class="cs-accordion-body">
      <ul class="list-unstyled">
        <li>
          <!-- employees -->
          <a href="employee_management.php" class="nav-link d-flex align-items-center">
            <p class="my-2 px-2">Employee Management</p>
          </a>
        </li>

        <li>
          <a href="client-management.php" class="nav-link d-flex align-items-center">
            <p class="my-2 px-2">Client Management</p>
          </a>
        </li>

        <li>
          <a href="attendance-monitoring.php" class="nav-link d-flex align-items-center">
            <p class="my-2 px-2">Attendance Monitoring</p>
          </a>
        </li>
      </ul>
    </div>

    <!-- employee -->
    <a href="#" id="financeButton" class="nav-link d-flex align-items-center">
      <i class="fa-solid fa-peso-sign"></i>
      <p class="my-2 px-2">Finance</p>
      <i class="fa-solid fa-chevron-down" style="margin-left:auto! important;"></i>
    </a>
    <div id="financeAccordion" class="cs-accordion-body">
      <ul class="list-unstyled">
        <li>
          <!-- sales -->
          <a href="sales-report.php" class="nav-link d-flex align-items-center">
            <p class="my-2 px-2">Sales Report</p>
          </a>
        </li>

        <li>
          <a href="payroll.php" class="nav-link d-flex align-items-center">
            <p class="my-2 px-2">Employee Payroll</p>
          </a>
        </li>

      </ul>
    </div>



  <?php } ?>

  <a type="button" class="nav-link d-flex align-items-center text-danger" id="logout" data-bs-toggle="modal" data-bs-target="#LogoutModal">
    <i class="fa-solid fa-power-off"></i>
    <p class="my-2 px-2">Logout</p>
  </a>
</div>

<!-- Modal in logout-->
<div class="modal fade text-start" id="LogoutModal" tabindex="-1" aria-labelledby="LogoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center py-5">
        <h5>Are you sure to logout?</h5>
        <a type="button" href="config/employee-logout.php" class="btn btn-success rounded-pill">Yes</a>
        <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
      </div>
    </div>
  </div>
</div>