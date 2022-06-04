<?php
    //edit estate avatar

    @session_start();    

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: ../../app");
        exit(0);
    }

    if(!isset($_FILES['avatar']) || !isset($_POST['estateIdAvatar']))
    {
        $_SESSION['profileEditAvatarError'] = "Nie wskazano pliku awataru";
        header("Location: ../../adminPanelEstates");
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
                $newFileName = $_POST['estateIdAvatar'] . ".png";
                $fileDest = "../../img/estateAvatars/" . $newFileName;
                chmod($fileDest, 0777);
                chmod("../../img/estateAvatars/", 0777);

                try
                {
                    //move file to folder
                    move_uploaded_file($fileTmp, $fileDest);
                    $_SESSION['estateAvatarEditSuccess'] = "Zdjęcie zostało zmienione";
                }
                catch(Exception $e)
                {
                    echo $e;
                    $_SESSION['estateAvatarEditError'] = "Błąd w przesyłaniu pliku";
                }
            }
        }
    }

    header("Location: ../../adminPanelEstates");
?>