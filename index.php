<?php
    @session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Witaj w Hoodbook | Twoje osiedle w jednym miejscu</title>
    <?php include "meta.php"; ?>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="img/hoodbook_logo_horizontal-small.svg" style="width: 150px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Strona Główna</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#about">O nas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#offer">Oferta</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="signUp">Utwórz konto</a>
                </li>

                <?php
                    if(!isset($_SESSION['loggedUser']))
                    {
                        echo ('
                            <li class="nav-item">
                                <a class="nav-link" href="signIn">Zaloguj się</a>
                            </li>
                        ');
                    } else {
                        echo ('
                        <li class="ms-auto nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> ');
                            echo $_SESSION['loggedUser'];
                            echo ('</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                <li><a class="dropdown-item" href="app">Kokpit</a></li>
                                <li><a class="dropdown-item" href="app">Przeglądaj</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout">Wyloguj się</a></li>
                            </ul>
                        </li>
                        ');
                    }
                ?>
                

            </ul>
            </div>
        </div>
    </nav>

        <section id="home" class="hero-section">
            <div class="container">
                <div class="row" style="min-height: 100vh;">

                    <div class="col-12 col-md-10 col-lg-8 d-flex align-items-center">
                        <div class="welcome-screen">
                            <h1 class="display-1 fw-bold">Hoodbook</h1>
                            <p class="fs-4">Witaj w aplikacji Hoodbook, dzięki której w łatwy sposób możesz dowiedzieć się o nadchodzących wydarzeniach na swoim osiedlu lub je tworzyć.</p>

                            <div class="d-flex mt-3">
                                <a href="#about" class="welcome-know-btn me-3">Dowiedz się więcej</a>
                                <a href="signUp" class="welcome-register-btn">Zarejestruj się</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="scroll-down">
                <a href="#about" class=""><i class='bx bxs-chevrons-down text-white fs-1'></i></a>
            </div>

        </section>

        <div class="wave">
            <svg width="100%" height="355px" viewBox="0 0 1920 155" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#f8f9fa">
                        <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
                    </g>
                </g>
            </svg>
        </div>

        <section class="bg-light" id="about">
            <div class="container">
                <div class="row gx-4 align-items-center py-5" style="min-height: 100vh;">

                    <div class="col-12 text-center mb-5" style="z-index: 2;">
                        <h2 class="display-3 fw-bold">Co oferuje aplikacja Hoodbook?</h2>
                        <p class="fs-5 text-muted px-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor reiciendis quis animi dolorem commodi eos minus, earum ullam autem expedita error quod sunt, sequi, mollitia cum saepe nobis. Doloribus qui ea soluta molestiae magni quia. Dolores eius dignissimos esse. Temporibus?</p>
                    </div>        

                    <!-- About #01 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="p-3 py-5 bg-white rounded-3 d-flex flex-column align-items-center justify-content-center about-card">
                            <img src="img/apartment.png" alt="" class="img-fluid w-75">
                            <h3 class="mt-4">Znajdź swoje osiedle</h3>
                            <p class="text-muted text-center fs-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eum nihil inventore corporis tenetur aut, error accusantium explicabo repellat quos laudantium.</p>
                        </div>
                    </div>

                    <!-- About #02 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="p-3 py-5 bg-white rounded-3 d-flex flex-column align-items-center justify-content-center about-card">
                            <img src="img/soft-skills.png" alt="" class="img-fluid w-75">
                            <h3 class="mt-4">Przeglądaj informacje</h3>
                            <p class="text-muted text-center fs-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eum nihil inventore corporis tenetur aut, error accusantium explicabo repellat quos laudantium.</p>
                        </div>
                    </div>

                    <!-- About #03 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="p-3 py-5 bg-white rounded-3 d-flex flex-column align-items-center justify-content-center about-card">
                            <img src="img/maid.png" alt="" class="img-fluid w-75">
                            <h3 class="mt-4">Poznawaj nowych ludzi</h3>
                            <p class="text-muted text-center fs-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eum nihil inventore corporis tenetur aut, error accusantium explicabo repellat quos laudantium.</p>
                        </div>
                    </div>      
                </div>
            </div>
        </section>

        <section class="bg-light" id="offer">
            <div class="container">
                <div class="row gx-4 align-items-center justify-content-center py-5" style="min-height: 100vh;">
                    <div class="col-12 col-md-6">
                        <h2 class="display-5">Hoodbook - wszystko czego potrzebujesz</h2>
                        <p class="fs-5 text-muted mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae officia tempora similique rerum voluptatem ut, dolore adipisci dignissimos magni earum quos saepe enim quod recusandae deserunt eaque labore vero. Officia in eaque sunt a culpa expedita minima aut neque architecto?</p>
                        <p class="fs-5 text-muted mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, sint reiciendis delectus natus nulla officiis praesentium? Earum libero accusamus beatae vero. Maiores commodi dignissimos corrupti!</p>
                        <p class="fs-5 text-muted mt-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit.  <a href="">Deserunt quisquam aperiam</a> praesentium, sed animi nam.</p>
                    </div>

                    <div class="col-12 col-md-6">
                        <img src="img/estates-img1.jpg" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="d-none d-lg-flex" id="cta">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-around" style="min-height: 23vh;">
                    
                    <div class="col-12 col-lg-9">
                        <div class="d-flex justify-content-center align-items-center flex-wrap">
                            <h2 class="text-white">Nie zwlekaj! Zarejestruj się i przetestuj jak działa Hoodbook</h2>
                            <a href="signUp" class="cta-button ms-5">Rejestracja</a>
                        </div>
                    </div>
            
                </div>
            </div>
        </section>

        <section class="bg-light" id="offer2">
            <div class="container">
                <div class="row gx-4 align-items-center justify-content-center py-5" style="min-height: 100vh;">

                    <div class="col-12 col-md-6">
                        <img src="img/undraw_mobile_encryption_re_yw3o.svg" class="img-fluid">
                    </div>

                    <div class="col-12 col-md-6">
                        <h2 class="display-5">Czy Hoodbook jest dla mnie?</h2>
                        <p class="fs-5 text-muted mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae officia tempora similique rerum voluptatem ut, dolore adipisci dignissimos magni earum quos saepe enim quod recusandae deserunt eaque labore vero. Officia in eaque sunt a culpa expedita minima aut neque architecto?</p>
                        <p class="fs-5 text-muted mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, sint reiciendis delectus natus nulla officiis praesentium? Earum libero accusamus beatae vero. Maiores commodi dignissimos corrupti!</p>
                        <p class="fs-5 text-muted mt-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt quisquam aperiam praesentium, sed animi nam.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-dark" id="footer">
            <div class="container">
                <div class="row align-items-center justify-content-center" style="min-height: 7vh">
                    <p class="text-muted text-center mb-0">Wszelkie prawa zastrzeżone &copy; 2022 Hoodbook</p>
                </div>
            </div>
        </section>

    </body>

</html>