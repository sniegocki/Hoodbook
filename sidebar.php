<?php
@session_start();
?>

<div class="sidebar">
  <div class="logo-details">
    <img src="img/hoodbook_logo_symbol.svg" width="30" alt="NPROFIT SYMBOL">
    <span class="logo_name">Hoodbook</span>
  </div>

  <!-- MENU -->
  <ul class="nav-links">

    <!-- Home -->
    <li>
      <a href="app">
        <i class='bx bxs-dashboard' ></i>
        <span class="link_name">Kokpit</span>
      </a>

      <ul class="sub-menu blank">
        <li><a class="link_name" href="app">Kokpit</a></li>
      </ul>

    </li>

    <!-- Profil -->
    <li>
      <a href="profile">
        <i class='bx bxs-user-circle' ></i>
        <span class="link_name">Mój profil</span>
      </a>

      <ul class="sub-menu blank">
        <li><a class="link_name" href="app">Mój profil</a></li>
      </ul>

    </li>
     


    <!-- Logout -->
    <li>
      <a href="logout.php">
      <i class='bx bx-log-out'></i>
        <span class="link_name">Wyloguj</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="logout">Wyloguj</a></li>
      </ul>
    </li>

    <li>
    <div class="profile-details d-md-flex d-none">

        <div class="profile-content position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
          <?php
          $avatar_path = "./img/avatars/" . $_SESSION['loggedUser'] . ".png";

          if (file_exists($avatar_path)) {
              echo ('<img src="img/avatars/'.$_SESSION['loggedUser'].'.png">');
          } else {
              echo ('<img src="img/avatars/avatar_placeholder.png">');
          }
          ?>
          
        </div>

        <div class="name-job">
          <div class="profile_name">
            <?php echo $_SESSION['loggedUser'];?>
          </div>
        </div>
      </div>
    </li>
  </ul><!-- END OF NAVBAR -->
</div>