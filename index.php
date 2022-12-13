<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IITM Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/797f232dbd.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <style>
        body {
            animation: fadeIn .5s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .f-container {
            /* width: 400px; */
            display: flex !important;
            flex-wrap: wrap;
            gap: 5rem;
            justify-content: space-around !important;
            /* background-color: #222; */
        }
    </style>
</head>

<body>

    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php require 'partials/_functions.php' ?>

    <!-- Slider starts here -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/corousal1.jpg" class="d-block w-100" alt="...">

            </div>
            <div class="carousel-item">
                <img src="img/corousal2.jpg" class="d-block w-100" alt="...">

            </div>
            <div class="carousel-item">
                <img src="img/corousal3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Catergory container starts here -->
    <div class="container my-3">
        <h2 class="my-3 text-center">Forum Categories</h2>
        <div class="f-container my-5">
            <!-- Fetch all the categories from database and use a loop to iterate through categories -->
            <?php
            $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['category_id'];
                $cat = $row['category_name'];
                $desc = $row['category_description'];
                echo '
                <div class=" my-2">
                    <div class="card" style="width: 18rem;">
                        <img loading="lazy" src="img/card' . $id . '.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '" class="text-decoration-none fw-bolder">' . $cat . '</a></h5>
                            <p class="card-text">' . substr($desc, 0, 99) . '</p>
                            <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>

    </div>

    <?php include 'partials/_footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>