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
    <title>Login</title>
</head>
<body>
    <main>
        <article class="container">
            <h2 id="login-title">Login to your account</h2>
            <br>
            <span id="errorMessage" class="login-error"></span>
            <div class="center">
                <form class="form-group" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="box">
                        <label for="username" class="labelCenter">Username: </label>
                        <span id="userNameLoginError" class="input-error"></span>
                    </div>
                    <input id="username" class="form-control" placeholder="Enter username" type="text">
                    <div class="box">
                        <label for="password" class="labelCenter">Password: </label>
                        <span id="passwordLoginError" class="input-error"></span>
                    </div>
                    <input id="password" class="form-control" placeholder="Enter password" type="password">
                    <div>
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me </label>
                    </div>
                </form>
                <button id="submit" class="btn btn-primary" type="submit" name="login">Login</button>
                <h3 id="register-text">Don't have an account yet? <a href="registerForm.php">Register now!</a></h3>
            </div>
        </article>
    </main>

    <?php

        if (isset($_COOKIE['remember'])) {
            if(isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
                $username = $_COOKIE['username'];
                $password  = $_COOKIE['password'];
    
                function debug_to_console($data) {
                    $output = $data;
                    if (is_array($output))
                        $output = implode(',', $output);
                
                    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
                }
                
    
                echo "
                    <script>
                        $('#username').val('$username');
                        $('#password').val('$password');
                    </script>
                ";            
            }
            echo "
                <script>
                    $('#remember').prop('checked', true);
                </script>
            ";
        } else {
            echo "
                <script>
                    $('#remember').prop('checked', false);
                </script>
            ";
        }
    ?>

    <script>
        function setSpanMissingText() {
            console.log("setmissing");
            $("#username").val() == "" ? $("#userNameLoginError").text("Missing") : $("#userNameLoginError").text("");
            $("#password").val() == "" ? $("#passwordLoginError").text("Missing") : $("#passwordLoginError").text("");
        }

        function clearSpans() {
            console.log("clear spans");
            $("#userNameLoginError").text("");
            $("#passwordLoginError").text("");
        }

        $(function() {
            $("#submit").click(function () {
            var username = $("#username").val();
            var password = $("#password").val();

            if (username == "" || password == "") {
                $("#errorMessage").text("");
                setSpanMissingText();
            } else {
                var user = { 
                    username: username, 
                    password: password 
                };
                var userJSON = JSON.stringify(user);

                $.ajax({
                    method: "POST",
                    url: "../helpers/validateLoginInput.php",
                    data: { user: userJSON },

                    success: function(result) {
                        console.log("validate result: " + result);
                        clearSpans();
                        if (result == "Success") {
                            $("#errorMessage").text("");
                            login();
                        } else {
                            $("#errorMessage").text("Invalid username or password. Try again!");
                        }
                    }
                });

                function login() {
                    var remembered = $('#remember').is(':checked');

                    $.ajax({
                        method: "POST",
                        url: "login.php",
                        data: { 
                            user: userJSON,
                            remember: remembered
                        },

                        success: function(result) {
                            console.log("login result: " + result);
                            if (result == "Success") {
                                window.location.href = "main.php";
                            } else {
                                $("#errorMessage").text("Invalid username or password. Try again!");
                            }
                        }
                    });
                }
            }
        });
        })
    </script>
</body>
</html>