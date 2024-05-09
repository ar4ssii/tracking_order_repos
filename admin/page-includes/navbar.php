
<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-new-danger mx-0">
    <div class="container-fluid d-flex bd-highlight">
      <a class="navbar-brand px-2 py-0 bd-highlight text-white fw-bold" href="#" style="border-right: 2px solid #efefef; ">System</a>
      <span class="text-uppercase text-light p-2 bd-highlight" style=" margin-left: -10px!important;"><?= $_SESSION['user_info']['role_name'] ?></span>
      <!-- <a class="navbar-brand p-2 bd-highlight text-white fw-bold" href="#">System</a> -->

      <div class="ms-auto p-2 bd-highlight hide-user">
        <span class="d-flex align-items-center py-1 bg-secondary rounded-pill" style="padding-right: 10px;">
        <?php if(isset($_SESSION['auth'])){ ?>
          <i class="fa fa-solid fa-circle-user text-white fa-2x mx-2"></i><span class="text-white text-uppercase px-3"><?= $_SESSION['user_info']['FullName'] ?></span>
        <?php } ?>
        </span>
      </div>
    </div>
  </nav>