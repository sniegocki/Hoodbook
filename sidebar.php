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
     
    <!-- Osiedle -->
    <li>
      <div class="iocn-link">
        <a>
          <i class='bx bxs-buildings' ></i>
          <span class="link_name">Moje osiedla</span>
        </a>
        <i class="bx bxs-chevron-down arrow"></i>
      </div>

      <ul class="sub-menu">
        <li><a class="link_name" href="#">Moje osiedla</a></li>
        <li><a href="browseEstates">Przeglądaj</a></li>
        <li><a href="chooseEstate">Posty</a></li>
      </ul>
    </li>

    <!-- Administracja -->
    <?php
    if($_SESSION['permission'] == 2) {
     echo ('
     <li>
        <div class="iocn-link">
          <a>
            <i class="bx bx-shield-quarter"></i>
            <span class="link_name">Administracja</span>
          </a>
          <i class="bx bxs-chevron-down arrow"></i>
        </div>

        <ul class="sub-menu">
          <li><a class="link_name" href="#">Administracja</a></li>
          <li><a href="adminPanelUsers">Zarządzaj użytkownikami</a></li>
          <li><a href="adminPanelEstates">Zarządzaj osiedlami</a></li>
          <li><a href="adminPanelApplications">Zarządzaj zgłoszeniami</a></li>
        </ul>
      </li>
     ');
    }
    ?>
    

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
            <?php
            
              //display user name and surname
              $sql = "SELECT Users.Name, Users.Surname FROM Users WHERE Id=" . $_SESSION['loggedUser'] . ";";
              require "PHPMethods/connect.php";
              $result = $connect->query($sql);
              $row = $result->fetch_assoc();
              echo $row["Name"] . " " . $row['Surname'];
            ?>
          </div>
        </div>
      </div>
    </li>
  </ul><!-- END OF NAVBAR -->
</div>

<script src="js/sidebar.js"></script>