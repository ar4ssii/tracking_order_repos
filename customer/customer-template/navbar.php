<?php if (isset($_SESSION['auth'])) { ?>


    <?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'index.php' ? 'active' : '' ?>" href="index.php">Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'transaction.php' ? 'active' : '' ?>" href="transaction.php">Transactions</a>
                    </li>
                </ul>

                <?php if (isset($_SESSION['auth'])) { ?>
                    <div class="d-flex ml-auto ">
                        <div class="dropdown mx-3">

                            <a class="nav-link row d-flex align-items-center dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="col px-1"> <span class="fas fa-user-circle fa-2x text-info"></span></div>
                                <div class="col px-0"><?= $_SESSION['user_info']['name'];
                                                        ?> </div>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#LogoutModal">Logout</a></li>
                            </ul>
                        </div>

                    </div>
                <?php } ?>

            </div>
        </div>

    </nav>


    <!-- Modal in logout-->
    <div class="modal fade text-start" id="LogoutModal" tabindex="-1" aria-labelledby="LogoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <h5>Are you sure to logout?</h5>
                    <a type="button" href="customer-config/logout.php" class="btn btn-success rounded-pill">Yes</a>
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>