<?php
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <title>صفحه اصلی</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">
    <!--style-->
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/indexsite.css">
    <link rel="stylesheet" href="css/clock.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
    <nav style="--bs-bg-opacity: 0.95;" class="navbar sticky-top navbar-expand-lg p-2 py-3 shadow-sm navbar-light bg-light">
        <div class="container-fluid d-flex flex-row-reverse justify-content-around align-items-center">
            <div class="d-flex flex-row-reverse justify-content-between align-items-center" style="direction: ltr;">
                <a class="navbar-brand">دبیرستان شهید هاشمی نژاد 4</a>
                <a class="navbar-brand" href="#">
                    <img src="http://www.hns4.ir/docs/hns4ir/schoollogo.jpg" class="border border-successّ rounded-circle" alt="" width="40" height="40">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <span id="clock" class="clock me-lg-4" style="direction: ltr;"></span>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if (isset($_SESSION['ok'])) {
                    ?>
                        <a class="navbar-brand"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?></a>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link btn-outline-success p-2 px-3 mx-1 rounded color-white" href="<?php if (isset($_SESSION['access'])) {
                                                                                                            if ($_SESSION['access'] == "admin") {
                                                                                                                echo "index.php?usercontrol=1";
                                                                                                            } elseif ($_SESSION['access'] == "student") {
                                                                                                                echo "index.php?showscore=1";
                                                                                                            } elseif ($_SESSION['access'] == "teacher") {
                                                                                                                echo "index.php?controlscore=1";
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo "login/index.php";
                                                                                                        } ?>">ورود به پنل کاربری</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000" >
                    <img src="images/1.jpg" class="rounded-3 d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="images/2.jpg" class="rounded-3 d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/3.jpg" class="rounded-3 d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="container text-center py-md-5">
        <h2 class="mb-5">افتخارات</h2>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover table-danger shadow-sm">
                    <thead>
                        <tr>
                            <th scope="col">افتخارات هنری</th>
                            <th scope="col">نام</th>
                            <th scope="col">رشته</th>
                            <th scope="col">مقام</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/35/000000/external-rank-usa-flatart-icons-lineal-color-flatarticons.png" /></th>
                            <td>آقای ایکس</td>
                            <td>ویولون</td>
                            <td>اول ناحیه</td>
                        </tr>
                        <tr>
                            <th scope="row"><img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/35/000000/external-rank-usa-flatart-icons-lineal-color-flatarticons.png" /></th>
                            <td>آقای ایگرگ</td>
                            <td>معرق کاری</td>
                            <td>دوم استان</td>
                        </tr>
                        <tr>
                            <th scope="row"><img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/35/000000/external-rank-usa-flatart-icons-lineal-color-flatarticons.png" /></th>
                            <td>آقای زد</td>
                            <td>نقالی</td>
                            <td>سوم ناحیه</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-hover table-info table-striped shadow-sm">
                    <thead>
                        <tr>
                            <th scope="col">افتخارات قرآنی</th>
                            <th scope="col">نام</th>
                            <th scope="col">رشته</th>
                            <th scope="col">مقام</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/35/000000/external-rank-usa-flatart-icons-lineal-color-flatarticons.png" /></th>
                            <td>آقای ایکس</td>
                            <td>حفظ 5 جز</td>
                            <td>دوم استان</td>
                        </tr>
                        <tr>
                            <th scope="row"><img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/35/000000/external-rank-usa-flatart-icons-lineal-color-flatarticons.png" /></th>
                            <td>آقای ایگرگ</td>
                            <td>ترتیل</td>
                            <td>اول ناحیه</td>
                        </tr>
                        <tr>
                            <th scope="row"><img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/35/000000/external-rank-usa-flatart-icons-lineal-color-flatarticons.png" /></th>
                            <td>آقای زد</td>
                            <td>قرائت</td>
                            <td>سوم استان</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--contact-->
    <div class="py-4">
        <section class="container bg-warning py-5 rounded-3 shadow-sm border-warning bg-opacity-25 border-2 border">
            <h2 class=" text-center fs-1 mt-4 mb-5">اطلاعات بیشتر</h2>
            <hr>
            <div class="row g-4">
                <div class="col-md-6 mt-md-5 pt-md-5">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-center rounded p-4">
                                <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                                <h2 class="mt-4">آدرس</h2>
                                <div>میدان جهاد، بزرگراه شهید کلانتری</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center rounded p-4">
                                <svg class=" text-primary mb-1" xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                                <h2 class="mt-4">شماره تماس</h2>
                                <div>8882 3841 051</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center rounded p-4">
                                <svg class=" text-primary" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                </svg>
                                <h2 class="mt-4">دوره اول</h2>
                                <div>مقطع متوسطه اول</div>
                                <div></div>

                            </div>
                        </div>
                        <div class="text-center col-md-6">
                            <div class="  rounded p-4">
                                <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                </svg>
                                <h2 class="mt-4">مدیریت</h2>
                                <div>جناب آقای علیرضا نجفی ثانی</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="">
                        <div class="accordion shadow-sm" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        آدرس دقیق
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <iframe class="mt-3 container-fluid" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1608.3493718607162!2d59.57247813140623!3d36.27109219280902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f6c9151c274c2cd%3A0x29c50f447e520272!2sHasheminejad%204%20Middle%20School!5e0!3m2!1sen!2s!4v1645026616890!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="container text-center">
        <hr>
        <p>Designed and Developed by <strong><a style="color: #6906df" class="text-decoration-none" target="new" href="https://t.me/M_A_Tatari">Mohammad Amin Tatari</a></strong><br>2022-<?php echo date("Y"); ?>&copy; </p>
    </div>
    <!--back to top-->
    <a class="bg-warning text-dark d-flex rounded-circle justify-content-center align-items-center position-fixed opacity-75" style=" z-index: 10; width: 54px; height: 54px; right: 10px; bottom: 10px;" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
        </svg>
    </a>
    <script src="js/clock.js"></script>
    <script>
        window.localStorage.setItem("login", "yes");
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
