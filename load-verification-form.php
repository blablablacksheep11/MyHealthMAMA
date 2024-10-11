<?php
session_start();
$entity = $_SESSION["entity"];
echo "<p class='card-text my-0 mx-0'>Enter the verification code sent to your email.</p>";
echo "<form action='../authentication/forgot-pass.php' method='post' autocomplete='off'>";
echo "<div class='row mt-3'>";
echo "<div class='col mx-1 p-0'>";
echo "<input type='number' class='form-control m-0 text-center fs-2 numberfield' id='num1'>";
echo "</div>";
echo "<div class='col mx-1 p-0'>";
echo "<input type='number' class='form-control m-0 text-center fs-2 numberfield' id='num2'>";
echo "</div>";
echo "<div class='col mx-1 p-0'>";
echo "<input type='number' class='form-control m-0 text-center fs-2 numberfield' id='num3'>";
echo "</div>";
echo "<div class='col mx-1 p-0'>";
echo "<input type='number' class='form-control m-0 text-center fs-2 numberfield' id='num4'>";
echo "</div>";
echo "</div>";
echo "<input type='submit' class='btn btn-primary mt-4 w-100' name='verify-btn' id='verify-btn' value='Verify' disabled>";
echo "</form>";
echo "<div class='row mx-0 mt-2'>";
echo "<div class='col text-center'>";
echo "<a href='forgot-pass-$entity.php' class='link-primary'>Back</a>";
echo "</div>";
echo "</div>";

//focus on the next number field after then current is filled
echo "<script>
document.getElementById('num1').addEventListener('input', checknum1);
document.getElementById('num2').addEventListener('input', checknum2);
document.getElementById('num3').addEventListener('input', checknum3);
document.getElementById('num4').addEventListener('input', checknum4);

var num1filled = false;
var num2filled = false;
var num3filled = false;
var num4filled = false;

function checknum1(){
    if(this.value.length > 0){
        num1filled = true;
        document.getElementById('num2').focus();
    }else{
        num1filled = false;
        document.getElementById('verify-btn').disabled = true;
    }
    if(num1filled == true && num2filled == true && num3filled == true && num4filled == true){
        document.getElementById('verify-btn').disabled = false;
    }
}

function checknum2(){
    if(this.value.length > 0){
        num2filled = true;
        document.getElementById('num3').focus();
    }else{
        num2filled = false;
        document.getElementById('verify-btn').disabled = true;
    }
    if(num1filled == true && num2filled == true && num3filled == true && num4filled == true){
        document.getElementById('verify-btn').disabled = false;
    }
}

function checknum3(){
    if(this.value.length > 0){
        num3filled = true;
        document.getElementById('num4').focus();
    }else{
        num3filled = false;
        document.getElementById('verify-btn').disabled = true;
    }
    if(num1filled == true && num2filled == true && num3filled == true && num4filled == true){
        document.getElementById('verify-btn').disabled = false;
    }
}

function checknum4(){
    if(this.value.length > 0){
        num4filled = true;
    }else{
        num4filled = false;
        document.getElementById('verify-btn').disabled = true;
    }
    if(num1filled == true && num2filled == true && num3filled == true && num4filled == true){
        document.getElementById('verify-btn').disabled = false;
    }
}
</script>";
