<!-- Side navigation -->
<div class="sidenav">
  <div class="d-flex align-items-center pt-2">
    <h4 class="mt-1 px-2 text-white text-uppercase">System</h4>
  </div>
  <hr class="hr-sidenav">
  <a href="index.php" class="nav-link d-flex align-items-center">
    <i class="fa-solid fa-gauge"></i>
    <p class="my-2 px-2">Dashboard</p>
  </a>
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
      <li>
        <a href="products.php">Products</a>
      </li>

    </ul>
  </div>

  <!-- employees -->
  <a href="employee_management.php" class="nav-link d-flex align-items-center">
    <i class="fa-solid fa-users"></i>
    <p class="my-2 px-2">Employee Management</p>
  </a>

  <!-- sales -->
  <a href="sales.php" class="nav-link d-flex align-items-center">
    <i class="fa-solid fa-peso-sign"></i>
    <p class="my-2 px-2">Sales Report</p>
  </a>
</div>