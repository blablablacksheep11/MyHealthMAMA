<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>MyHealthMAMA</title>
    <style>
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
        }
        </style>
</head>
<body style="background-image: url(img/background3.jpg);background-repeat:no-repeat; background-size:cover;">

    <?php
    include("../include/header.php");
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include("sidenav.php");
                    ?>

                </div>
                <div class="col-md-10">
                    <h5 class="text-center" style="color: #1434A4;">Doctor Account Request</h5>

                    <div id="show"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){

            show();
            
            function show(){
                $.ajax({
                    url: "ajax_doctor_request.php",
                    method:"POST",
                    success:function(data){
                        $("#show").html(data);
                    }

                    });
            }

            $(document).on('click', '.approve', function(){

                var id = $(this).attr("id");
                
                $.ajax({
                    url:"ajax_approve.php",
                    method:"POST",
                    data:{id:id},
                    success:function(data){
                        show();
                    }
                })
            });

            $(document).on('click', '.reject', function(){

                    var id = $(this).attr("id");

                $.ajax({
                    url:"ajax_reject.php",
                    method:"POST",
                    data:{id:id},
                    success:function(data){
                        show();
    }
})
});
        });
        </script>

<div class="footer">
        <p>Copyright by TAN YIT JIE. All Rights Reserved.</p>
    </div>

</body>
</html>