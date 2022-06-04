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

    if(isset($_SESSION['addCommentPostSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['addCommentPostSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['addCommentPostSuccess']);
    }

    if(isset($_SESSION['addCommentPostError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['addCommentPostError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['addCommentPostError']);
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
                                            <span class="postIdCtn d-none">' . $postId . '</span>
                                            <span class="estateIdCtn d-none">' . $postIdEstate . '</span>');

                                            //count likes
                                            $sqlCount = "SELECT count(*) FROM ReactionsPosts WHERE IdPost=" . $postId . " GROUP BY IdPost;";
                                            $resultCount = $connect->query($sqlCount);
                                            $commentsCount = 0;
                                            if($resultCount->num_rows > 0)
                                            {
                                                while($row = $resultCount->fetch_assoc())
                                                {
                                                    $commentsCount++;
                                                }
                                            }

                                            //like, dislike post
                                            $sqlPost = "SELECT * FROM ReactionsPosts WHERE IdPost=" . $postId . " AND IdAuthor=" . $_SESSION['loggedUser'] . ";";
                                            $resultPost = $connect->query($sqlPost);
                                            if($resultPost->num_rows == 1)
                                            {
                                                echo('<a href="likeDislikePost?postId=' . $postId . '&estateId=' . $postIdEstate . '&userId=' . $_SESSION['loggedUser'] . '" class="text-primary text-decoration-none me-3"><i class="bx bxs-like text-primary"></i> Lubisz to!</a>');
                                            }
                                            else
                                            {
                                                echo('<a href="likeDislikePost?postId=' . $postId . '&estateId=' . $postIdEstate . '&userId=' . $_SESSION['loggedUser'] . '" class="text-primary text-decoration-none me-3"><i class="bx bxs-like text-primary"></i> Polub to!</a>');
                                            }


                                            echo ('
                                            <a data-bs-toggle="modal" data-bs-target="#addcommentpost" class="text-secondary text-decoration-none makePostCommentBtn" style="cursor: pointer;"><i class="bx bxs-comment text-secondary"></i> Skomentuj</a>
                                            <span>' . $commentsCount . ' osób lubi ten post!</span>
                                        </div>
                                    </div>');


                                     $sql = "SELECT * FROM Comments WHERE IdPost=" . $postId . " ORDER BY Date ASC;";

                                     $resultComments = $connect->query($sql);
                                     if($resultComments->num_rows > 0) {
                                        echo "<div class='postComments mt-3 '>";

                                        while($rowComment = $resultComments->fetch_assoc()) {
                                            echo "<div class='postComment bg-light px-3 py-2 mb-3 rounded-3 position-relative w-100'>";
                                            $sqlUser = "SELECT Users.Id, Users.Name, Users.Surname FROM Users WHERE Id=" . $rowComment['IdAuthor'] . ";";
                                            $resultUser = $connect->query($sqlUser);
                                            $commentId = $rowComment['Id'];

                                            if($resultUser->num_rows == 1) {
                                                $rowUser = $resultUser->fetch_assoc();
                                                $avatarPath = "img/avatars/" . $rowUser['Id'] . ".png";

                                                echo ('<div class="d-flex ">');

                                                if (file_exists($avatarPath)) {
                                                    echo "
                                                        <div class='avatar-place'>
                                                            <img class='img-fluid rounded-pill' src='" . $avatarPath . "' alt='Zdjęcie profilowe' style='max-width: 50px;'>
                                                        </div>";
                                                } else {
                                                    echo "
                                                        <div class='avatar-place'>
                                                            <img class='profile-avatar' src='" . "img/avatars/avatarPlaceholder.png" . "' alt='Zdjęcie profilowe' style='max-width: 50px;'>
                                                        </div>";
                                                }
                                                
                                                echo ('<div class="d-flex flex-column ms-3 w-100 ">');
                                                echo "<a class='user-name fw-bold text-decoration-none' target='_blank' href='profile?user=" . $rowUser['Id'] . "'>" . $rowUser['Name'] . " " . $rowUser['Surname'] . "<i class='fw-light text-muted'> - skomentował:</i></a><span class='commentDate text-muted fw-light border-bottom pb-1'>" . $rowComment['Date'] . "</span>";


                                                echo "<p class='comment-content mt-2 mb-0 text-muted'>" . $rowComment['TextContent'] . "</p>";
                                                echo "</div>";

                                                //delete comment button
                                                if ($rowComment['IdAuthor'] == $_SESSION['loggedUser'] || $_SESSION['permission'] == '2') {
                                                    echo "<a href='deleteComment?commentId=$commentId&estateId=$postIdEstate' class='delete-post' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Usuń komentarz'>&times;</a>";
                                                } 
                                                
                                                echo "</div>";
                                            echo "</div>";
                                            }
                                        }
                                        
                                     }
                            echo ('
                                </div>
                            </div>
                            ');

                        }

                        
                    } 
                ?>
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

    <!-- Add comment modal -->
    <div class="modal fade" id="addcommentpost" tabindex="-1" aria-labelledby="addcommentpost" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addcomment">Dodaj komentarz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/addComment_script" method="POST">

                    <input type="text" max="60" name="postId" id="postId" class="form-control" value="" autocomplete="off" style="display: none;">
                    <input type="text" max="60" name="estateId" id="estateId" class="form-control" value="" autocomplete="off" style="display: none;">

                    <label for="postComment" class="form-label mb-1 mt-3">Komentarz: </label>
                    <textarea class="form-control" name="postComment" id="postComment" cols="30" rows="10" required></textarea>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="editEstate" class="btn btn-success">Dodaj komentarz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            //Add comment modal data =>
            document.querySelectorAll(".makePostCommentBtn").forEach(o => {
                o.addEventListener("click", ()=> {
                    let postId = o.parentNode.querySelector(".postIdCtn").outerText;
                    let estateId = o.parentNode.querySelector(".estateIdCtn").outerText;
                    
                    var postIdInput = document.querySelector("#addcommentpost #postId");
                    var estateIdInput = document.querySelector("#addcommentpost #estateId");

                    postIdInput.value = postId;
                    estateIdInput.value = estateId;
                });
            });
            //<=Add comment modal data 
        });  

    </script>
    <script src="js/toast.js"></script>
    <script src="js/tooltips.js"></script>
</body>
</html>