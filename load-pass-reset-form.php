<?php
echo "<p class='card-text my-0 mx-0'>Enter your new password.</p>";
echo "<form action='../authentication/forgot-pass.php' method='post' autocomplete='off'>";
echo "<input type='password' class='form-control mt-4' id='password' placeholder='Password'>";
echo "<input type='password' class='form-control mt-4' id='con-password' placeholder='Confirm-password'>";
echo "<input type='submit' class='btn mt-4 w-100' name='reset-btn' id='reset-btn' value='Reset' disabled style='background-color: #FFB0B0; color:white'>";
echo "</form>";
echo "<div class='row mx-0 mt-2'>";
echo "<div class='col text-center'>";
echo "<a href='index.php' class='link-primary'>Login</a>";
echo "</div>";
echo "</div>";

//enable submit btn when email txtfield is filled
echo "<script>
document.getElementById('password').addEventListener('input', checkpassword);
document.getElementById('con-password').addEventListener('input', checkconpassword);
let passfilled = false;
let conpassfilled = false;

function checkpassword() {
    if (this.value.length > 0) {
        passfilled = true;
    } else {
        passfilled = false;
        document.getElementById('reset-btn').disabled = true;
    }
    if (passfilled == true && conpassfilled == true) {
        document.getElementById('reset-btn').disabled = false;
    }
}

function checkconpassword() {
    if (this.value.length > 0) {
        conpassfilled = true;
    } else {
        conpassfilled = false;
        document.getElementById('reset-btn').disabled = true;
    }
    if (passfilled == true && conpassfilled == true) {
        document.getElementById('reset-btn').disabled = false;
    }
}
</script>";
