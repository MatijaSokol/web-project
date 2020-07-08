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
    <title>Registration</title>
</head>
<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link text-warning" href="main.php">Home</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-warning" href="index.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <article class="container">
            <h2 id="login-title">Create account</h2>
            <div class="center-register">
                <form class="form-group form-group-register" method="POST" enctype="application/x-www-form-urlencoded">
                    <div>
                        <div class="box">
                            <label for="firstname" class="labelCenter">First name: </label>
                            <span id="firstNameError" class="register-error"></span>
                        </div>
                        <input id="firstname" class="form-control" placeholder="Enter first name" type="name">
                    </div>
                    <div>
                        <div class="box">
                            <label for="lastname">Last name: </label>
                            <span id="lastNameError" class="register-error"></span>
                        </div>
                        <input id="lastname" class="form-control" placeholder="Enter last name" type="name">
                    </div>
                    <div>
                        <div class="box">
                            <label for="username">Username: </label>
                            <span id="userNameError" class="register-error"></span>
                        </div>
                        <input id="username" class="form-control" placeholder="Enter username" type="name">
                    </div>
                    <div>
                        <div class="box">
                            <label for="password">Password: </label>
                            <span id="passwordError" class="register-error"></span>
                        </div>
                        <input id="password" class="form-control" placeholder="Enter password" type="password">
                    </div>
                    <div>
                        <div class="box">
                            <label for="email">Email: </label>
                            <span id="emailError" class="register-error"></span>
                        </div>
                        <input id="email" class="form-control" placeholder="Enter email" type="email">
                    </div>
                </form>
                <button id="submit" class="btn btn-primary" type="submit">Register</button>
            </div>
        </article>
    </main>

    <script>
        function setSpanMissingText() {
            console.log("setmissing");
            $("#firstname").val() == "" ? $("#firstNameError").text("Missing") : $("#firstNameError").text("");
            $("#lastname").val() == "" ? $("#lastNameError").text("Missing") : $("#lastNameError").text("");
            $("#username").val() == "" ? $("#userNameError").text("Missing") : $("#userNameError").text("");
            $("#password").val() == "" ? $("#passwordError").text("Missing") : $("#passwordError").text("");
            $("#email").val() == "" ? $("#emailError").text("Missing") : $("#emailError").text("");
        }

        function clearSpans() {
            $("#firstNameError").text("");
            $("#lastNameError").text("");
            $("#userNameError").text("");
            $("#passwordError").text("");
            $("#emailError").text("");
        }

        function setSpanErrorText(result) {
            switch(result) {
                case "FirstName":
                    $("#firstNameError").text("Invalid!");
                    break;
                case "LastName":
                    $("#lastNameError").text("Invalid!");
                    break;
                case "Username":
                    $("#userNameError").text("Invalid!");
                    break;
                case "Password":
                    $("#passwordError").text("Invalid!");
                    break;
                case "Email":
                    $("#emailError").text("Invalid!");
                    break;
                default:
                    break;
            }
        }

        $("#submit").click(function () {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            var username = $("#username").val();
            var password = $("#password").val();
            var email = $("#email").val();

            if (firstname == "" || lastname == "" || username == "" || password == "" || email == "") {
                setSpanMissingText();
            } else {
                var user = { 
                    firstname: firstname, 
                    lastname: lastname, 
                    username: username, 
                    password: password, 
                    email: email 
                };
                var userJSON = JSON.stringify(user);

                $.ajax({
                    method: "POST",
                    url: "../helpers/validateRegisterInput.php",
                    data: { user: userJSON },

                    success: function(result) {
                        clearSpans();
                        if (result === "Success") {
                            register();
                        } else {
                            setSpanErrorText(result);
                        }
                    }
                });

                function register() {
                    $.ajax({
                        method: "POST",
                        url: "register.php",
                        data: { user: userJSON },

                        success: function(result) {
                            if (result === "Success") {
                                alert("User successfully registered!");
                                window.location.href = "index.php";
                            } else {
                                alert("Error! Something went wrong.")
                            }
                        }   
                    });
                }
            }
        });
    </script>
</body>
</html>