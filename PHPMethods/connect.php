<?php

    //connection for all files
    $connect;

    try
    {
        $connect = @new mysqli('santiego.eu', 'nprofi15_santiego', '4g]N--hcf)-9MdGD', 'nprofi15_santiego');
    }
    catch(Exception $e)
    {
        echo "An error has occured: " . $e;
    }

?>