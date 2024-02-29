<?php
include("config.php");

if (isset($_POST["newId"])) {
    $userId = mysqli_real_escape_string($connection, $_POST["newId"]);
    $pass = mysqli_real_escape_string($connection, $_POST["newPass"]);
    $confirmPass = mysqli_real_escape_string($connection, $_POST["newConfirm"]);
    $animal = mysqli_real_escape_string($connection, $_POST["newAnimal"]);
    $data = mysqli_real_escape_string($connection, $_POST["newData"]);

    if ($userId == "" || $pass == "" || $animal == "" || $data == "") {
        echo "Both fields are required!";
        return;
    }

    if ($confirmPass != $pass) {
        echo "your password is not the same";
        return;
    }

    $idlen = strlen($userId);

    if ($idlen > 16) {
        echo "your id is more than 16";
        return;
    }

    if ($idlen < 4) {
        echo "your id is less than 4";
        return;
    }

    if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM mc_userinfo WHERE userId = '$userId'")) == 0) {
        mysqli_query($connection, "INSERT INTO mc_userinfo (userId , password, animal, data) VALUES ('$userId', '$pass', '$animal', '$data')");
        echo "Registering new account : user id " . $userId . ", password: " . $pass . " and animal: " . $animal . ", data: " . $data;
    } else {
        echo "This User Id is not avaible. Please use another user id";
    }
} else if (isset($_POST["loginId"])) {
    $userId = mysqli_real_escape_string($connection, $_POST["loginId"]);
    $pass = mysqli_real_escape_string($connection, $_POST["loginPass"]);
    if ($userId != "" && $pass != "") {
        $sql = "SELECT * FROM mc_userinfo WHERE userId = '$userId' AND password = '$pass'";
        if (mysqli_num_rows(mysqli_query($connection, $sql)) > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
} else if (isset($_POST["forgetId"])) {
    $userId = mysqli_real_escape_string($connection, $_POST["forgetId"]);
    $animal = mysqli_real_escape_string($connection, $_POST["forgetAnimal"]);
    if ($userId != "" && $animal != "") {
        $sql = "SELECT * FROM mc_userinfo WHERE userId = '$userId' AND animal = '$animal'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "Your Password: " . $row['password'];
        } else {
            echo 0;
        }
    } else {
        echo "Both fields are required!";
    }
} else if (isset($_POST["getJson"])) {
    $userId = mysqli_real_escape_string($connection, $_POST["getJson"]);
    if ($userId != "") {
        $sql = "SELECT * FROM mc_userinfo WHERE userId = '$userId'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row['data'];
        } else {
            echo 0;
        }
    }
} else if (isset($_POST["saveJson"])) {
    $userId = mysqli_real_escape_string($connection, $_POST["userId"]);
    $data = mysqli_real_escape_string($connection, $_POST["saveJson"]);
    if ($userId != "") {
        $sql = "SELECT * FROM mc_userinfo WHERE userId = '$userId'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            mysqli_query($connection, "UPDATE `mc_userinfo` SET `data` = '$data' WHERE `mc_userinfo`.`userId` = '$userId'");
            echo 1;
        } else {
            echo 0;
        }
    }
} else {
    echo "Merge Cafe Account";
}
