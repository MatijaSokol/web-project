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
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="form-inline my-2 my-lg-0" method="post">
                    <input id="query" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" id="search">Search</button>
                </form>
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="nav navbar-nav navbar-center mr-auto">
                    <li class="nav-item">
                        <span id="welcome-message">Welcome <?php echo $_SESSION["username"]; ?></span>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link text-warning" href="main.php">Home</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-warning" href="myAds.php">My ads</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-warning" href="newAdForm.php">New ad</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-warning" href="logout.php">Logout</a>
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
                $products = $productDbHelper->findAllMyAds($username);

                $element = '';

                for ($i = 0; $i < count($products); $i++) {
                    if ($i % 3 == 0) {
                        $element .= '<div class="row">';
                    }

                    $element .= '<div class="col-md-4">';
                    $element .= '<div class="card" style="width: 18rem;">';
                    $element .= '<img class="card-img-top" src="' . $products[$i]->image . '" alt="Card image cap" width="280" height="200">';
                    $element .= '<div class="card-body">';
                    $element .= '<div class="text-center"> <h5 class="card-title">' . $products[$i]->name . '</h5> </div>';
                    $element .= '<p class="card-text text-center">' . $products[$i]->price . ' kn</p>';
                    $element .= '<div class="text-center"> <button id="showMore" onclick="location.href=\'adDetails.php?id=' . $products[$i]->id . '\'" class="btn btn-primary">Show more</button> <button id="delete" onclick="location.href=\'deleteAd.php?id=' . $products[$i]->id . '\'" class="btn btn-danger">Delete</button> </div> </div> </div> </div>';

                    if ($i % 3 == 2) {
                        $element .= '</div> <br>';
                    }

                    echo $element;
                    $element = '';
                }

                $productDbHelper->closeConnection();

            ?>

        </div>
    </main>

    <script>

        $(document).ready(function() {
            const owner = '<?php echo $_SESSION['username']; ?>';

            $("#search").on('click', function(e){
                e.preventDefault();
                e.stopPropagation();

                const query = $("#query").val();
                if (query !== "") {
                    $.ajax({
                        method: "POST",
                        url: "getMySearchedAds.php",
                        data: {
                            query: query,
                            username: owner
                        },

                        success: function(resultJSON) {
                            setQueriedElements(Array.from(JSON.parse(resultJSON)));
                        }
                    });
                }
            });

            function setQueriedElements(elements) {
                if (elements.length === 0) {
                    alert("No result found.");
                } else {
                    let element = '';
                    $(".container").empty();

                    for (let i = 0; i < elements.length; i++) {
                        if (i % 3 === 0) {
                            element += '<div class="row">';
                        }

                        element += '<div class="col-md-4">';
                        element += '<div class="card" style="width: 18rem;">';
                        element += '<img class="card-img-top" src="' + elements[i].image + '" alt="Card image cap" width="280" height="200">';
                        element += '<div class="card-body">';
                        element += '<div class="text-center"> <h5 class="card-title">' + elements[i].name + '</h5> </div>';
                        element += '<p class="card-text text-center">' + elements[i].price + ' kn</p>';
                        element += '<div class="text-center"> <button id="showMore" onclick="location.href=\'adDetails.php?id=' + elements[i].id.toString() + '\'" class="btn btn-primary">See more</button> <button id="showMore" onclick="location.href=\'deleteAd.php?id=' + elements[i].id.toString() + '\'" class="btn btn-danger">Delete</button> </div> </div> </div> </div>';

                        if (i % 3 === 2) {
                            element += '</div> <br>';
                        }
                    }

                    $('.container').append(element);
                }
            }
        })

    </script>
</body>
</html>