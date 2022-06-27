<?php

$serverName = "";
$username = "";
$password = "";
$database = "";

$connection = new mysqli($serverName, $username, $password, $database);

function connectToDB(&$connection) {

    if ($connection->connect_error) {
        die ("Connection failed: " . $connection->connect_error);
    }

    echo "Connected successfully.";

}

function validateCredentials($login, $password, &$connection) {
    $sqlStatement = "SELECT `login`, `password` FROM `users`";
    $data = $connection->query($sqlStatement);

    if ($data->num_rows > 0) {
        while ($row = $data->fetch_array()) {
            if ($row["login"] == $login && $row["password"] == $password) {
                return true;
            }
        }
    }
    return false;
}

function registerAccount($login, $password, &$connection) {
    $sqlStatementValidating = "SELECT `login` FROM `users`";
    $data = $connection->query($sqlStatementValidating);
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_array()) {
            if ($row['login'] == $login) {
                return false;
            }
        }
    }

    $sqlStatementInsert = "INSERT INTO `users` (`login`, `password`) VALUES ('$login', '$password')";
    if ($connection->query($sqlStatementInsert)) {
        return true;
    }

    return false;
}

function getTotalCount(&$connection) {
    $qTotal = "SELECT COUNT(*) FROM `grammarexercises`";
    $dataTotal = $connection->query($qTotal);
    global $totalNrExercise;
    if ($dataTotal->num_rows > 0) {
        $row = $dataTotal->fetch_row();
        $totalNrExercise = $row[0];
    }

    return $totalNrExercise;
}

function getSelectedCount($type, &$connection) {
    $q = "SELECT COUNT(*) FROM `grammarexercises` WHERE `type`='$type'";
    $dataTotal = $connection->query($q);
    $typeNrExercise = 0;
    if ($dataTotal->num_rows > 0) {
        $row = $dataTotal->fetch_row();
        $typeNrExercise = $row[0];
    }

    return $typeNrExercise;
}

function getSelectedExercise($type, &$connection){
    $exercises = array();
    $sqlStatementSelecting = "SELECT `question`, `hiragana`, `answer` FROM `grammarexercises` WHERE `type`='$type'";
    $data = $connection->query($sqlStatementSelecting);
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_array()) {
            $exercises[] = $row;
        }
    }
    return $exercises;
}
