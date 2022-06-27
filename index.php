<?php

include_once "databaseConnection.php";

if (isset($_POST['proceedRegister'])) {
    header("Location:register.php");
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
<div class="titleNihongo">
    日本語の文法練習
</div>

<br>

<div class="main">

    Welcome!
    <br>

    <label class="h2nihongo">このウエブサイトへよこうそ!</label>

    <br>

    Please log in or register:

    <br>
    <br>

    <FORM action="index.php" method="POST">
        <TABLE class="table">
            <TR>
                <TD><b>Login: </b></TD>
                <TD><INPUT name="login" placeholder="Enter Login" type="text" required></TD>
            </TR>
            <TR>
                <TD><b>Password: </b></TD>
                <TD><INPUT name="password" placeholder="Enter Password" type="text" required></TD>
            </TR>
        </TABLE>
        <br>
        <button name="proceedLogin" class="button" onclick="form.submit()"><span>Log in</span></button>
        <br>

        <?php

        if (isset($_POST['proceedLogin'])) {

            if (validateCredentials($_POST["login"], $_POST["password"], $connection)) {

                session_start();

                $_SESSION['user'] = $_POST["login"];

                header("Location:dashboard.php");

                exit();

            } else {

                echo "<p class='message'>Wrong login and/or password</p>";
            }
        }

        ?>

        <br>

    </FORM>

    <FORM action="index.php" method="POST">
        Don't have an account?
        &nbsp
        <button name="proceedRegister" class="button" onclick="form.submit()"><span>Register</span></button>
    </FORM>

</div>

</BODY>