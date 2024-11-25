    <?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include("../include/header.php");
    include("../include/connection.php");
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MyHealthMAMA</title>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            .footer {
                background-color: pink;
                padding: 10px;
                color: white;
                text-align: center;
                position: fixed;
                bottom: 0;
                width: 100%;
                left: 0;
                right: 0;
            }

            #block{
                display: none;
                position: absolute;
                top: 32.5%;
                left: 30%;
                height: 35%;
                width: 40%;
            }

            #replyfield{
                position: absolute;
                height: 100%;
                width: 100%;
                resize: none;
                outline: none;
            }

            #submitbtn{
                position: absolute;
                bottom: 2%;
                right: 1%;
            }

            #cancelbtn{
                position: absolute;
                bottom: 2%;
                right: 15%;
            }
        </style>
    </head>
    <body style="background-image: url(img/background3.jpg);background-repeat:no-repeat; background-size:cover;">

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php include("sidenav.php"); ?>
                </div>
                <div class="col-md-10">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="my-4" style="color: #1434A4;">Feedback Messages</h2>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mothers</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            // Fetch feedback data from the database
                                            $doctorUsername = $_SESSION['doctor'];
                                            $getdoctorid = "SELECT id FROM doctors WHERE username='$doctorUsername'";
                                            $result = mysqli_query($connect, $getdoctorid);
                                            $doctorid = mysqli_fetch_column($result);
                                            $feedbackQuery = "SELECT id,title, description,sender_username FROM feedback WHERE receiver_id='$doctorid'";
                                            $feedbackResult = mysqli_query($connect, $feedbackQuery);
                                            if (!$feedbackResult) {
                                                die("Query failed: " . mysqli_error($connect));
                                            }
                                            while ($row = mysqli_fetch_assoc($feedbackResult)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['sender_username'] . "</td>";
                                                echo "<td>" . $row['title'] . "</td>";
                                                echo "<td>" . $row['description'] . "</td>";
                                                echo "<td><form method='post' action='report.php'><button class='btn btn-primary replybtn' style='color:white' value=".$row['id']." name='replybtn'>Reply</button></form></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    <div id="block">
        <textarea name="replyfield" id="replyfield" placeholder="Add a reply here...."></textarea>
        <button type="submit" class="btn btn-primary" id="submitbtn" name="submitbtn">Submit</button>
        <button type="reset" class="btn btn-danger" id="cancelbtn" name="cancelbtn">Cancel</button>
    </div>
    <script>
        $(document).ready(function(){

            //when cancel button clicked
            $(document).on("click","#cancelbtn", function(e){
                e.preventDefault();
                $('#block').hide(); //hide the text area
            })

            //when submit button clicked
            $(document).on("click","#submitbtn", function(e){
                e.preventDefault();
                var reply = $('#replyfield').val(); 

                $.ajax({
                    type:  'POST',
                    url:  'add-reply.php',
                    data: {
                        reply: reply,
                    },
                    success: function(){
                        alert('Reply added');
                        $('#block').hide(); //hide the text area
                }
            })
            })
        })
    </script>
    </body>
    </html>

    <?php
    if(isset($_POST["replybtn"])){
        $_SESSION["feedbackid"] = $_POST["replybtn"];
        $feedbackid = $_POST["replybtn"];
        echo "<script>document.getElementById('block').style.display='block'</script>";
        $sql = "SELECT reply FROM feedback WHERE id='$feedbackid'";
        $result = mysqli_query($connect,$sql);
        $row = mysqli_fetch_column($result);
        echo "<script>document.getElementById('replyfield').value='".$row."'</script>";
    }
    ?>
