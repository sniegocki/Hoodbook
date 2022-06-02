<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: app");
        exit(0);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | Twoje osiedle</title> 
    <?php include "meta.php"; ?>
</head>
<body>

    <?php 
        require "PHPMethods/connect.php";
        require "sidebar.php";
    ?>

    <section class="home-section bg-light">
        <div class="home-content p-3 justify-content-center">

            <div class="row g-3 w-100 flex-column align-items-center">
                <h2 class="text-center">Najnowsze aktualności</h2>

                

                <?php
                    if(!$connect->connect_error) {
                        //Estates table
                        $sql = "SELECT Posts.Id, Posts.IdEstate, Posts.IdAuthor, Posts.Date, Posts.TextContent, Posts.Type FROM Posts;";
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
                            <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-6">
                                <div class="bg-white p-3 rounded shadow-sm mb-3">
                                    <div class="d-flex flex-wrap">
                                        <!-- Post Author -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-place">
                                                <img src="img/avatars/'.$userId.'.png" class="img-fluid rounded-pill me-2" alt="Zdjęcie użytkownika '.$userName.' '.$userSurname.'" style="max-width: 50px;">
                                            </div>

                                            <div class="d-flex flex-column">
                                                <span class="text-muted"><b>'.$userName.' '.$userSurname.'</b> - dodał nowy post</span>
                                                <small class="text-muted">'.$postDate.'</small>
                                            </div>
                                        </div>
                            ');

                            echo ('
                                            <hr class="w-100">

                                            <!-- Post Content -->
                                            <div class="text-muted">'.$postContent.'</div>

                                            <!-- Post Footer -->
                                            <hr class="w-100" style="color: rgba(0,0,0,0.2);">

                                            <div class="d-flex">
                                            <a href="#" class="text-primary text-decoration-none me-3"><i class="bx bxs-like text-primary"></i> Polub</a>
                                            <a href="#" class="text-secondary text-decoration-none"><i class="bx bxs-comment text-secondary" ></i> Skomentuj</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ');

                        }

                        
                    } 
                ?>

                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-6">
                    <div class="bg-white p-3 rounded shadow-sm mb-3">
                        <div class="d-flex flex-wrap">
                            <!-- Post Author -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-place">
                                    <img src="img/avatars/avatarPlaceholder.png" class="img-fluid rounded-pill me-2" alt="Zdjęcie użytkownika Patryk Kowalski" style="max-width: 50px;">
                                </div>

                                <div class="d-flex flex-column">
                                    <span class="text-muted"><b>Maks Śniegocki</b> - dodał nowy post (ten post jest w <code>html</code>)</span>
                                    <small class="text-muted">02.06.2022 19:30</small>
                                </div>
                            </div>

                            <hr class="w-100">

                            <!-- Post Content -->
                            <p class="text-muted">Cieszę się z Pride Month!</p>
                            <p class="text-muted">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa aliquid recusandae eveniet amet quidem incidunt esse nostrum quaerat. Laudantium sed est, ullam, similique recusandae ea ab harum voluptatum quod velit, ipsam at. Quis debitis, optio voluptates quos soluta autem quod! ⚠</p>
                            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus ducimus maxime nihil neque est magnam debitis consequatur commodi velit deleniti! 🤣</p>

                            <!-- Post Footer -->
                            <hr class="w-100" style="color: rgba(0,0,0,0.2);">

                            <div class="d-flex">
                                <a href="#" class="text-primary text-decoration-none me-3"><i class='bx bxs-like text-primary'></i> Polub</a>
                                <a href="#" class="text-secondary text-decoration-none"><i class='bx bxs-comment text-secondary' ></i> Skomentuj</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <script src="js/toast.js"></script>
</body>
</html>