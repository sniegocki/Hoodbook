<?php
    @session_start();
    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: signIn");
        exit(0);
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Hoodbook - Strona Główna, aplikacja do zarządzania osiedlem.</title> 
        <?php include "meta.php"; ?>
    </head>

    <body>
        <?php require "sidebar.php"; ?>
        <section class="home-section">
            <div class="home-content p-3 d-flex flex-column">
                
                <div class="row w-100">

                    <div class="col-12 col-lg-12 col-xl-5">
                        <div class="shadow-sm rounded bg-white p-3">
                            <h1 class="h1 mb-4">Witamy w Hoodbook!</h1>
                            <p class="text-muted">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sint, expedita maxime numquam totam tenetur quasi iure quibusdam dolorum quia repellendus possimus tempore dolores delectus aspernatur, animi voluptas laborum officiis iusto.</p>

                            <h3 class="h3 mt-4 text-muted">Zapoznaj się z aplikacja:</h3>
                            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, vitae. At nostrum dolor non ex commodi, laudantium provident dignissimos exercitationem! Porro dolores dolorem provident enim.</p>

                            <ul class="text-muted">
                                <li>Lorem ipsum dolor sit.</li>
                                <li>Lorem ipsum dolor sit amet. </li>
                                <li>Lorem, ipsum dolor. </li>
                                <li>Lorem, ipsum.</li>
                                <li>Lorem ipsum dolor sit amet.</li>
                            </ul>

                            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab laborum delectus accusamus quaerat sint neque quis eum numquam officia, eveniet fuga eligendi, harum aut repellat quisquam natus enim officiis repudiandae! <a href>Lorem, ipsum dolor.</a></p>

                            <h3 class="h3 mt-4 text-muted">Koalicja obywatelska wśród mieszkańców</h3>
                            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem odio sequi ad earum provident laborum expedita, voluptas totam quod porro ducimus sint unde harum perspiciatis natus deserunt mollitia maxime nam quidem delectus aliquam qui deleniti aut inventore. Laudantium harum nam corporis optio sequi voluptas, soluta ducimus repudiandae libero officiis culpa enim laborum ipsum vel ab molestias esse? Expedita, voluptates itaque!</p>
                            <p class="text-muted">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Est animi modi dolores, qui odio suscipit culpa nihil blanditiis laboriosam perferendis voluptates eum. Voluptate magnam sequi minus nostrum tempore magni dolorem.</p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12 col-xl-3">
                        <div class="d-flex flex-column shadow-sm rounded bg-white p-3">
                            <h3 class="text-muted">Ostatnie aktualności:</h3>

                            <div class="d-flex flex-column bg-light p-3 rounded">
                                <h5 class="h5 text-muted mb-0">Otwarcie sezonu grillowego</h5>
                                <p class="text-muted pb-2 border-bottom">01-06-2022 16:40</p>
                                <img src="https://inspectorusa.com/wp-content/uploads/2018/07/cookout-1080x675.jpg" alt="" class="img-fluid rounded-3" style="height: 200px; object-fit: cover;">
                                <p class="text-muted mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate qui temporibus amet repellendus, doloremque ex dolorum error, voluptatibus ea molestias sunt soluta illum iste autem...</p>         
                                <a href class="text-secondary">Czytaj więcej...</a>                  
                            </div>

                            <div class="d-flex flex-column bg-light p-3 rounded mt-3">
                                <h5 class="h5 text-muted mb-0">Festyn szkolny 2022</h5>
                                <p class="text-muted pb-2 border-bottom">20-04-2022 11:30</p>
                                <img src="https://jubail.isg.edu.sa/sites/jubail.isg.edu.sa/files/images/DSC_3630.JPG" alt="" class="img-fluid rounded-3" style="height: 200px; object-fit: cover;">
                                <p class="text-muted mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate qui temporibus amet repellendus, doloremque ex dolorum error, voluptatibus ea molestias sunt soluta illum iste autem...</p>         
                                <a href class="text-secondary">Czytaj więcej...</a>                  
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12 col-xl-4">
                        <div class="d-flex flex-column shadow-sm rounded bg-white p-3">
                            <h3 class="text-muted mb-2">Ostatnie posty:</h3>
                              <?php

                                require "PHPMethods/connect.php";

                                if(!$connect->connect_error) {
                                    //Estates table
                                    $sql = "SELECT * FROM Posts JOIN Estates ON Posts.IdEstate=Estates.Id JOIN Estates_Users ON Estates.Id=Estates_Users.IdEstate WHERE Estates_Users.IdUser= ".$_SESSION['loggedUser']." LIMIT 6";
                                    $result = $connect->query($sql);
            
                                    while($row = $result->fetch_assoc()) {
            
                                        $postId = $row['Id'];
                                        $postIdEstate = $row['IdEstate'];
                                        $postIdAuthor = $row['IdAuthor'];
                                        $postDate = $row['Date'];
                                        $postContent = $row['TextContent'];
                                        $postType = $row['Type'];
            
                                        $sql2 = "SELECT Users.Id, Users.Name, Users.Surname FROM Users WHERE Users.Id = ".$postIdAuthor.";";
                                        $result2 = $connect->query($sql2);
            
                                        while($row2 = $result2->fetch_assoc()) {
                                            $userId = $row2['Id'];
                                            $userName = $row2['Name'];
                                            $userSurname = $row2['Surname'];
                                        }
            
                                        echo ('
                                        <div class="col-12">
                                            <div class="bg-light p-3 rounded shadow-sm mb-3 position-relative">
                                            ');
                                            
            
                                            echo ('
                                                <div class="d-flex flex-wrap">
                                                    <!-- Post Author -->
                                                    <div class="d-flex align-items-center">

                                                    ');

                                                    $avatarPath = "img/avatars/" . $userId . ".png";

                                                    if (file_exists($avatarPath)) {
                                                        echo "
                                                            <div class='avatar-place'>
                                                                <img class='img-fluid rounded-pill me-2' src='" . $avatarPath . "' alt='Zdjęcie profilowe' style='max-width: 50px;'>
                                                            </div>";
                                                    } else {
                                                        echo "
                                                            <div class='avatar-place'>
                                                                <img class='profile-avatar rounded-pill me-2' src='" . "img/avatars/avatarPlaceholder.png" . "' alt='Zdjęcie profilowe' style='max-width: 50px;'>
                                                            </div>";
                                                    }

                                                        
                                            echo ('
                                                        <div class="d-flex flex-column">
                                                            <span class="text-muted"><b>'.$userName.' '.$userSurname.'</b></span>
                                                            <small class="text-muted">'.$postDate.'</small>
                                                        </div>
                                                    </div>
                                        ');
            
                                        echo ('
                                                    <hr class="w-100">
        
                                                    <!-- Post Content -->
                                                    <div class="text-muted">'.$postContent.'</div>
                                                </div>
                                            </div>');
                                        }
                                    }
                              ?>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </body>
</html>