<?php
    //edit user avatar

    @session_start();    

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: ../app");
        exit(0);
    }

    if(!isset($_FILES['avatar']))
    {
        $_SESSION['profileEditAvatarError'] = "Nie wskazano pliku awataru";
        header("Location: ../profile");
        exit(0);
    }

    $file = $_FILES['avatar'];

    //File properties
    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = explode('.', $fileName);
    $fileExt = strtolower(end($fileExt));

    $allowed = array("png", "jpg", "jpeg", "gif");

    if(in_array($fileExt, $allowed))
    {
        //file not error
        if($fileError === 0)
        {
            //file size check
            if($fileSize <= 5000000)
            {
                $newFileName = $_SESSION['loggedUser'] . ".png";
                $fileDest = "../img/avatars/" . $newFileName;
                chmod($fileDest, 0777);
                chmod("../img/avatars/", 0777);

                try
                {
                    //move file to folder
                    move_uploaded_file($fileTmp, $fileDest);
                    $_SESSION['profileEditAvatarSuccess'] = "Zdjęcie zostało zmienione";
                }
                catch(Exception $e)
                {
                    echo $e;
                    $_SESSION['profileEditAvatarError'] = "Błąd w przesyłaniu pliku";
                }
            }
        }
    }

    header("Location: ../profile");
?>