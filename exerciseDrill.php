<?php
include_once "databaseConnection.php";

session_start();

error_reporting(E_ALL ^ E_WARNING);

if (isset($_POST['goBack'])) {
    header("Location:dashboard.php");
    exit();
}

$type = $_SESSION['chosen'];
$typeCount = count($_SESSION['selectedExerciseArr']);

$questionRandSelect = $_SESSION['questionRandSelect'];

$question = $_SESSION['selectedExerciseArr'][$questionRandSelect]["question"];
$hiragana = $_SESSION['selectedExerciseArr'][$questionRandSelect]["hiragana"];
$answer = $_SESSION['selectedExerciseArr'][$questionRandSelect]["answer"];

?>


<head>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<BODY>

<div class="main">

    <FORM action="exerciseDrill.php" method="POST">
        Show hiragana? <button name="hiraganaOn" class="button" onclick="form.submit()" style="font-size:15px"><span>Yes</span>
            &nbsp <button name="hiraganaOff" class="button" onclick="form.submit()" style="font-size:15px"><span>No</span></button>
            <?php

            if (isset($_POST['hiraganaOn']) && !isset($_COOKIE['HiraganaOn'])) {
                setcookie("HiraganaOn", true, time() + (60 * 2));
                echo "<p class='question' style='font-size:20px'>$hiragana";
            }

            $check = false;

            if (isset($_POST['hiraganaOff'])) {
                unset($_COOKIE['HiraganaOn']);
                setcookie("HiraganaOn", false, time() - (60 * 10));
                $_POST['hiraganaOn'] = false;
                $check = true;
            }

            if (!$check) {
                if (isset($_COOKIE['HiraganaOn'])) {
                    echo "<p class='question' style='font-size:20px'>$hiragana";
                }
            }


            ?>

            <p class="question"><?php echo $question ?></p>
            <br>

            Your answer: <input name="userAnswer" type="text"> &nbsp

            <br>

            <button name="answerSubmit" class="button" onclick="form.submit()"><span>Check</span></button>

    </FORM>



    <FORM action="exerciseDrill.php" method="POST">
        <?php
        if (isset($_POST['answerSubmit'])) {
            $string = transliterator_transliterate("Latin-Hiragana", $_POST["userAnswer"]);
            if ($string == $answer) {
                $_SESSION['blocked'] = false;
                unset($_SESSION['selectedExerciseArr'][$questionRandSelect]);
                $_SESSION['selectedExerciseArr'] = array_values($_SESSION['selectedExerciseArr']);
                echo "Correct!";
                echo "<br>";
                $_SESSION['questionRandSelect'] = rand(0,count($_SESSION['selectedExerciseArr'])-1);
                echo "<button name='proceed' class='button' onclick='form.submit()'><span>Next exercise</span></button>";
            } else {
                $_SESSION['blocked'] = true;
                $_SESSION['questionRandSelect'] = $questionRandSelect;
                echo "Try again.";
            }
        }

        if (isset($_POST['proceed'])) {
            if ($typeCount == 0) {
                echo "<p class='message'>There are no more exercises.</p>";
                echo "<p class='message'>Redirecting to your dashboard...</p>";
                header("refresh:2;url=dashboard.php");
                exit();
            }
        }



        ?>
        <br>
        <button name="goBack" class="button" onclick="form.submit()" style="font-size:15px"><span>Go back</span></button>
    </FORM>

</div>


</BODY>
