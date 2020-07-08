<?php

require_once '../db/MyPDO.php';
require_once '../db/ProductDbHelper.php';
require_once '../db/UserDbHelper.php';

$id = $_GET['id'];

$productDbHelper = ProductDbHelper::getInstance(MyPDO::getInstance());
$userDbHelper = UserDbHelper::getInstance(MyPDO::getInstance());

$ad = $productDbHelper->findAdById($id);
$user = $userDbHelper->findUserByUsername($ad->owner);

$productDbHelper->closeConnection();
$userDbHelper->closeConnection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="../../styles/styleDetails.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline my-2 my-lg-0 invisible" method="post">
            <input id="query" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" id="search">Search</button>
        </form>
        <ul class="navbar-nav mr-auto">
        </ul>
        <ul class="nav navbar-nav navbar-center mr-auto">
            <li class="nav-item">
                <?php
                session_start();
                if(isset($_SESSION['username'])) {
                    echo '<span id="welcome-message">Welcome ' . $_SESSION["username"] . '</span>';
                }
                ?>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <ul class="navbar-nav mr-auto">
                <?php
                if(isset($_SESSION['username'])) {
                    echo '<li class="nav-item active">
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
                                      </li>';
                } else {
                    echo '<li class="nav-item active">
                                            <a class="nav-link text-warning" href="main.php">Home</a>
                                      </li>
                                      <li class="nav-item active">
                                            <a class="nav-link text-warning" href="index.php">Login</a>
                                      </li>
                                      <li class="nav-item active">
                                            <a class="nav-link text-warning" href="registerForm.php">Register</a>
                                      </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container emp-profile">
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <img src="<?php echo $ad->image; ?>" alt=""/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                        <?php echo $ad->name; ?>
                    </h5>
                    <h6>
                        <?php echo $ad->owner; ?>
                    </h6>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                    <p><?php echo $ad->description; ?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $ad->name; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Description</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $ad->description; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Price</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $ad->price; ?> kn</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Contact</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $user->email; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>