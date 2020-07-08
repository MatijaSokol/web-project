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
    <link rel="stylesheet" href="../../styles/styleNewAd.css">
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
                <form class="form-inline my-2 my-lg-0 invisible" method="post">
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

        <article class="container">
            <h2 id="login-title">New ad</h2>
            <span id="errorMessage" class="login-error"></span>
            <div class="center">
                <form class="form-group" method="POST" enctype="multipart/form-data">
                    <div class="box">
                        <label for="name" class="labelCenter">Product name: </label>
                        <span id="nameError" class="input-error"></span>
                    </div>
                    <input id="name" class="form-control" placeholder="Enter product name" type="text">
                    <br>
                    <div class="box">
                        <label for="description" class="labelCenter">Description: </label>
                        <span id="descriptionError" class="input-error"></span>
                    </div>
                    <input id="description" class="form-control" placeholder="Enter description" type="text">
                    <br>
                    <div class="box">
                        <label for="price" class="labelCenter">Price: </label>
                        <span id="priceError" class="input-error"></span>
                    </div>
                    <input id="price" class="form-control" placeholder="Enter price [kn]" type="number" step="0.01">
                    <br>
                    <div class="box">
                        <label for="fileToUpload" class="labelCenter">Image: </label>
                        <span id="imageError" class="input-error"></span>
                    </div>
                    <input id="file" class="form-control-file btn btn-info" name="file" type="file">
                    <br> 
                    <br>
                    <button id="create" class="btn btn-primary">Add</button>
                </form>
            </div>
        </article>
    </main>

    <script>
        function setSpanMissingText() {
            $("#name").val() === "" ? $("#nameError").text("Missing") : $("#nameError").text("");
            $("#description").val() === "" ? $("#descriptionError").text("Missing") : $("#descriptionError").text("");
            $("#price").val() === "" ? $("#priceError").text("Missing") : $("#priceError").text("");
            $("#file").get(0).files.length === 0 ? $("#imageError").text("Missing") : $("#imageError").text("");
        }

        $(document).ready(function() {
            const owner = '<?php echo $_SESSION['username']; ?>';

            $("#create").on('click', function(e){
                e.preventDefault();
                e.stopPropagation();

                const name = $("#name").val();
                const description = $("#description").val();
                const price = $("#price").val();
                const image = $("#file").get(0).files;

                if (name === "" || description === "" || price === "" || image.length === 0) {
                    setSpanMissingText();
                    return;
                }

                const ad = {
                    name: name,
                    description: description,
                    price: price
                }

                const adJSON = JSON.stringify(ad);

                $.ajax({
                    method: "POST",
                    url: "../helpers/validateNewAdInput.php",
                    data: { ad: adJSON },

                    success: function(result) {
                        setSpanMissingText();
                        if (result === "Success") {
                            $("#errorMessage").text("");
                            uploadImage();
                        } else {
                            $("#errorMessage").text("Invalid name, description or price. Try again!");
                        }
                    }
                });
            });

            function uploadImage() {
                const fd = new FormData();
                const files = $('#file')[0].files[0];
                fd.append('file', files);

                $.ajax({
                    url: 'uploadImage.php',
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(result){
                        if (result.toString() === "0") {
                            $("#errorMessage").text("Sorry, image format is invalid. Please select another.");
                            setSpanMissingText();
                        } else if (result.toString() === "1") {
                            $("#errorMessage").text("Sorry, same image already exists. Please select another.");
                            setSpanMissingText();
                        } else if (result.toString() === "2") {
                            $("#errorMessage").text("Something went wrong. Please try again.");
                            setSpanMissingText();
                        } else {
                            uploadInDatabase(result);
                        }
                    },
                });
            }

            function uploadInDatabase(imagePath) {
                const username = $("#name").val();
                const description = $("#description").val();
                const price = $("#price").val();

                const ad = {
                    name: username,
                    description: description,
                    price: price,
                    owner: owner,
                    image: imagePath
                };
                const adJSON = JSON.stringify(ad);

                $.ajax({
                    method: "POST",
                    url: "insertNewAd.php",
                    data: { ad: adJSON },

                    success: function(result) {
                        if (result === "success") {
                            window.location.href = "main.php";
                        }
                    }
                });
            }
        })
    </script>
</body>
</html>