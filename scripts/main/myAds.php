<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        // write error to $_SESSION
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../styles/styleMain.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="nav navbar-nav navbar-center mr-auto">
                    <li class="nav-item">
                        <a class="no-hover" href="#">Welcome <?php echo $_SESSION["username"]; ?></a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="main.php">Home</a>
                        </li>
                         <li class="nav-item active">
                            <a class="nav-link" href="newAdForm.php">New ad</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="myAds.php">My ads</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
         </main>
        

<br> <br>

        <div class="container">

        <?php
                require_once '../db/MyPDO.php';
                require_once '../db/ProductDbHelper.php';
                require_once '../model/Product.php';

                $mypdo = MyPDO::getInstance();
                $productDbHelper = ProductDbHelper::getInstance($mypdo);

                $username =  $_SESSION['username'];
                $products = $productDbHelper->findAllMyProducts($username);

                $element = '';

                for ($i = 0; $i < count($products); $i++) {
                    if ($i % 3 == 0) {
                        $element .= '<div class="row">';
                    }

                    $element .= '<div class="col-sm">';
                    $element .= '<div class="card" style="width: 18rem;">';
                    $element .= '<img class="card-img-top" src="' . $products[$i]->image . '" alt="Card image cap" width="280" height="200">';
                    $element .= '<div class="card-body">';
                    $element .= '<div class="text-center"> <h5 class="card-title">' . $products[$i]->name . '</h5> </div>';
                    $element .= '<p class="card-text text-center">' . $products[$i]->price . ' kn</p>';
                    $element .= '<div class="text-center"> <a href="#" class="btn btn-primary">See more</a> </div> </div> </div> </div>';

                    if ($i % 3 == 2) {
                        $element .= '</div> <br>';
                    }

                    echo $element;
                    $element = '';
                }

            ?>

        </div>
    </main>
</body>
</html>