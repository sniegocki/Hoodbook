<?php

    @session_start();
    @session_destroy();
    @session_unset();
    $_SESSION = array();

    @session_start();
    $_SESSION['signOut_success'] = "Wylogowano z systemu";
    header("Location: ../signIn");
    exit(0);

?>