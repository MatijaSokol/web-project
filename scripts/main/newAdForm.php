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
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <main>
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
                        <span id="priceError" class="input-error"></span>
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
        $(document).ready(function() {
            const owner = '<?php echo $_SESSION['username']; ?>';

            $("#create").on('click', function(e){
                e.preventDefault();
                e.stopPropagation();

                var fd = new FormData();
                var files = $('#file')[0].files[0];
                fd.append('file', files);

                $.ajax({
                    url: 'uploadImage.php',
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(imagePath){
                        if (imagePath != 0) {
                            console.log(imagePath);
                            uploadInDatabase(imagePath);
                        }
                    },
                });
            });

            function uploadInDatabase(imagePath) {
                const username = $("#name").val();
                const password = $("#description").val();
                const price = $("#price").val();

                const ad = {
                    name: username,
                    description: password,
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
                        if (result == "success") {
                            window.location.href = "main.php";
                        }
                    }
                });
            }
        })
    </script>
</body>
</html>