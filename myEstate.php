<?php
    @session_start();

    //refresh page for post changes
    

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: app");
        exit(0);
    }

    $actualEstate = $_GET['estate'];

    require "PHPMethods/connect.php";

    $checkAffiliation = "SELECT * FROM Estates_Users WHERE IdEstate=".$actualEstate." AND IdUser= ".$_SESSION['loggedUser'].";";
    $result = $connect->query($checkAffiliation);

    if($result->num_rows == 1) {
        //należy do osiedla
    } else {
        header("Location: javascript:history.go(-1)");
    }

    //prompt success or error status
    if(isset($_SESSION['addPostSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['addPostSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['addPostSuccess']);
    }

    if(isset($_SESSION['addPostError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['addPostError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['addPostError']);
    }

    if(isset($_SESSION['deltePostSucces']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['deltePostSucces'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['deltePostSucces']);
    }

    if(isset($_SESSION['deltePostError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['deltePostError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['deltePostError']);
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

    <?php include "sidebar.php"; ?>

    <section class="home-section bg-light">
        <div class="home-content p-3 justify-content-center">

            <div class="row g-3 w-100 flex-column align-items-center">
                <h2 class="text-center">Najnowsze aktualności</h2>

                <?php
                    if(!$connect->connect_error) {
                        //Estates table
                        $sql = "SELECT Posts.Id, Posts.IdEstate, Posts.IdAuthor, Posts.Date, Posts.TextContent, Posts.Type FROM Posts WHERE Posts.IdEstate = ".$actualEstate." ORDER BY Posts.Date DESC;";
                        $result = $connect->query($sql);

                        echo ('
                                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-6">
                                    <div class="bg-white p-3 rounded shadow-sm mb-3">
                                        <button class="btn text-muted w-100" style="border: 3px dashed rgba(0,0,0,0.15);" data-bs-toggle="modal" data-bs-target="#addPost">
                                            <i class="bx bx-plus text-muted"></i> Utwórz nowy post
                                        </button>
                                    </div>
                                </div>
                            ');

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
                                <div class="bg-white p-3 rounded shadow-sm mb-3 position-relative">
                                ');
                                
                                if ($postIdAuthor == $_SESSION['loggedUser'] || $_SESSION['permission'] == '2') {
                                    echo "<a href='deletePost?postId=$postId&estateId=$postIdEstate' class='delete-post' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Usuń post'>&times;</a>";
                                }   

                                echo ('
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

    <!-- Add Post Modal -->
    <div class="modal fade" id="addPost" tabindex="-1" aria-labelledby="addPost" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPost">Dodaj post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/addPost_script" method="POST">

                    <input type="number" name="toEstate" value="<?php echo $actualEstate; ?>" class="d-none">

                    <!-- <label for="postTitle" class="form-label">Tytuł posta:</label>
                    <input type="text" name="postTitle" id="postTitle" class="form-control" minlength="6" maxlength="50" required> -->

                    <label for="postContent" class="form-label">Treść posta:</label>
                    <textarea name="postContent" id="postContent" cols="30" rows="10" minlength="4" class="form-control" required></textarea>

                    
                    <label for="formFile" class="form-label mt-3">Wstaw obrazki</label>
                    <input class="form-control" type="file" id="formFile" disabled>
                    <small class="text-muted">Funkcja dodawania obrazków do postów wyłącznie dla użytkowników Premium.</small>
                    
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="editUser" class="btn btn-success">Dodaj post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/toast.js"></script>
    <script src="js/tooltips.js"></script>
</body>
</html>