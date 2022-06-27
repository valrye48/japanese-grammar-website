<?php

include_once "databaseConnection.php";

if (isset($_POST['goBack'])) {
    header("Location:index.php");
    exit();
}

?>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<BODY>

<FORM action="register.php" method="POST">

    <div class="main">

        Register an account:

        <br>
        <br>

    <table class="table">
        <TR>
            <td style="text-align:center"><b>Choose a login:</b></td>

        </TR>
        <TR>
            <td><input name="loginRegister" placeholder="Enter login" type="text" required></td>
        </TR>
        <TR>
            <td style="text-align:center"><b>Choose a password:</b></td>

        </TR>
        <TR>
            <td><input name="passwordRegisterFirst" placeholder="Enter password" type="text" required></td>
        </TR>
        <TR>
            <td style="text-align:center"><b>Confirm your password:</b></td>

        </TR>
        <TR>
            <td><input name="passwordRegisterSecond" placeholder="Enter password" type="text" required></td>
        </TR>
    </table>

        <?php

        $check = false;

        if (isset($_POST['registerProceed'])) {
            if ($_POST['passwordRegisterFirst'] !== $_POST['passwordRegisterSecond']) {
                $check = true;
                echo "<p class='message'>The passwords differ.</p>";
            }
            if (!$check) {
                if (registerAccount($_POST['loginRegister'], $_POST['passwordRegisterFirst'], $connection)) {
                    echo "<p class='message'>Your account was registered! Click 'Go back' and log in.</p>";
                } else {
                    echo "<p class='message'>This login has already been taken.</p>";
                }
            }
        }


        ?>

    <button name="registerProceed" class="button" onclick="form.submit()"><span>Register</span></button>

        <br>
        <br>

</FORM>

<FORM action="register.php" method="POST">
    <button name="goBack" class="button" onclick="form.submit()" style="font-size:15px"><span>Go back</span></button>
</FORM>

</div>

</BODY>
