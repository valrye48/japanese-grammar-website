<?php

include_once "databaseConnection.php";

session_start();

if (isset($_POST['goBack'])) {
    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_POST['randomExercise'])) {
    $_SESSION['counter'] = 0;
    $_SESSION['chosen'] = "random";
    $_SESSION['blocked'] = false;
    $type = "";
    $randomSelect = rand(0,1);
    switch ($randomSelect) {
        case 0: $type = "particles"; $_SESSION['questionRandSelect'] = rand(0, getSelectedCount($type, $connection)-1);
            break;
        case 1: $type = "verbcon"; $_SESSION['questionRandSelect'] = rand(0, getSelectedCount($type, $connection)-1);
            break;
    }

    $_SESSION['chosen'] = $type;
    $_SESSION['selectedExerciseArr'] = getSelectedExercise($type, $connection);
    header("Location:exerciseDrill.php");
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

<div class="main">

    Welcome, <b><?php echo $_SESSION['user'] ?></b>!

    <br>

    Pick the type of grammar you want to practice:

    <br>
    <br>

    <FORM action="dashboard.php" method="POST">

        <select name="selectExercise" class="selectList">
            <option>Particles</option>
            <option>Verb conjugation</option>
        </select>

    <br>
    <br>

    <button name="proceedExercise" class="button" onclick="form.submit()"><span>Practice</span></button>

        <?php
        if (isset($_POST['proceedExercise'])) {
        if ($_POST['selectExercise'] == "Particles") {
        $_SESSION['counter'] = 0;
        $_SESSION['chosen'] = "particles";
        $_SESSION['selectedExerciseArr'] = getSelectedExercise($_SESSION['chosen'], $connection);
        $_SESSION['questionRandSelect'] = rand(0, getSelectedCount($_SESSION['chosen'], $connection)-1);
        $_SESSION['blocked'] = false;
        header("Location:exerciseDrill.php");
        exit();
        } else if ($_POST['selectExercise'] == "Verb conjugation") {
        $_SESSION['counter'] = 0;
        $_SESSION['chosen'] = "verbcon";
        $_SESSION['selectedExerciseArr'] = getSelectedExercise($_SESSION['chosen'], $connection);
        $_SESSION['questionRandSelect'] = rand(0, getSelectedCount($_SESSION['chosen'], $connection)-1);
        $_SESSION['blocked'] = false;
        header("Location:exerciseDrill.php");
        exit();
        } else {
        echo "<br>";
        echo "Please choose an exercise type.";
        }

        }

        ?>

    </FORM>

    <br>

    Or get a random exercise:

    <FORM action="dashboard.php" method="POST">
        <button name="randomExercise" class="button" onclick="form.submit()"><span>Randomize</span></button>
    </FORM>

    <br>
    <br>

<FORM action="dashboard.php" method="POST">
    <button name="goBack" class="button" onclick="form.submit()" style="font-size:15px"><span>Log out</span></button>
</FORM>

</div>

</BODY>
