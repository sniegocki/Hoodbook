<?php

    $connect = @new mysqli('s110.linuxpl.com', 'nprofi15_santiego', '4g]N--hcf)-9MdGD', 'nprofi15_santiego');

    try
    {
        require "connect.php";
    }
    catch(Exception $e)
    {
        echo "An error has occured: " . $e;
    }

?>