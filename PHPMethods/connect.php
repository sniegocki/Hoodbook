<?php

    //connection for all files
    $connect;
    $connect = @mysqli_connect('santiego.eu', 'nprofi15_santiego', '4g]N--hcf)-9MdGD', 'nprofi15_santiego');

    if($connect)
    {
        //remote DB connection success
        mysqli_set_charset($connect, "utf8");
    }
    else
    {
        //echo "Trying to connect to local database";
        try
        {
            $connect = @new mysqli('localhost', 'nprofi15_santiego', '4g]N--hcf)-9MdGD', 'nprofi15_santiego');
        }
        catch(Exception $e)
        {
            echo "Local DB connection failed. Error:";
            echo $e;
        }
    }

    mysqli_set_charset($connect, "utf8");

?>

