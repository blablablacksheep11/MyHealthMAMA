<?php
session_start();
$_SESSION["entity"] = "mothers";
include("include/connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHealthMAMA</title>
    <!--import jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!---import bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .numberfield {
            height: 8vh;
        }

        #center-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #form-container {
            width: 350px;
        }

        /*disable the increase and decrease btn in the txtfield*/
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">
    <div class="container-fluid position-absolute h-100">
        <div class="row">
            <div class="d-none d-md-block col-md-3" style="background-color: transparent;"></div>
            <div class="col-sm-12 col-md-6 p-0" style="background-color: transparent;" id="center-container">
                <div class="card border bg-white p-0 text-center">
                    <div class="card-header m-0 h2 text-white" style="background-color: #FFB0B0;">Password Reset</div>
                    <div class="card-body p-5" id="form-container">
                        <p class="card-text my-0 mx-0">Enter your email and we will send you the verification code for password reset.</p>
                        <form action="../authentication/forgot-pass.php" method="post" autocomplete="off">
                            <input type="email" class="form-control mt-4" id="email" placeholder="email">
                            <input type="submit" class="btn mt-4 w-100" name="submit-btn" id="submit-btn" value="Submit" disabled style="background-color: #FFB0B0; color:white">
                        </form>
                        <div class="row mx-0 mt-2">
                            <div class="col text-center">
                                <a href="index.php" class="link-primary">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-3" style="background-color: transparent;"></div>
        </div>
    </div>
    <!--import bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            //generate a 4 digits verification code
            var num1 = Math.floor(Math.random() * 9);
            var num2 = Math.floor(Math.random() * 9);
            var num3 = Math.floor(Math.random() * 9);
            var num4 = Math.floor(Math.random() * 9);

            const verificationcode = num1.toString().concat(num2.toString(), num3.toString(), num4.toString())
            //when the submit btn clicked
            $(document).on("click", "#submit-btn", function(e) {
                e.preventDefault();
                var email = $("#email").val();

                if (email.includes("@gmail.com") || email.includes("@outlook.com")) {
                    //load the verification code form
                    $("#form-container").load("load-verification-form.php");

                    $.ajax({
                        type: "POST",
                        url: "send-verification-code.php",
                        data: {
                            verificationcode: verificationcode,
                            email: email
                        },
                        success: function() {
                            alert("Verification code has been sent to " + email);
                        }
                    })
                } else {
                    alert("Invalid email.");
                }
            })

            //when the verify btn clicked
            $(document).on("click", "#verify-btn", function(e) {
                e.preventDefault();
                var num1 = $("#num1").val();
                var num2 = $("#num2").val();
                var num3 = $("#num3").val();
                var num4 = $("#num4").val();

                const codetomatch = num1.toString().concat(num2.toString(), num3.toString(), num4.toString())

                if (codetomatch == verificationcode) {
                    $("#form-container").load("load-pass-reset-form.php");
                } else {
                    alert("Incorrect verification code");
                }
            })

            $(document).on("click", "#reset-btn", function(e) {
                e.preventDefault();
                const password = $("#password").val();
                const confirmpassword = $("#con-password").val();

                if (password == confirmpassword){
                    $.ajax({
                        type: "POST",
                        url: "update-password.php",
                        data: {
                            password: password
                        },
                        success: function(){
                            alert("Password has been updated");
                            window.location.replace("index.php");
                        }
                    })
                }else{
                    alert("Password does not match");
                }

            })
        })
    </script>
    <script>
        //enable submit btn when email txtfield is filled
        document.getElementById("email").addEventListener("input", checkemail);
        let condition1 = false;

        function checkemail() {
            if (this.value.length > 0) {
                condition1 = true;
            } else {
                condition1 = false;
                document.getElementById("submit-btn").disabled = true;
            }
            if (condition1 == true) {
                document.getElementById("submit-btn").disabled = false;
            }
        }
    </script>
</body>

</html>