<?php
require '../index.html';
//require 'connect.php';
//$name = $_REQUEST['name'];
//$phone = $_REQUEST['phone'];
//$email = $_REQUEST['email'];
//$street = $_REQUEST['street'];
//$home = $_REQUEST['home'];
//$part = $_REQUEST['part'];
//$appt = $_REQUEST['appt'];
//$floor = $_REQUEST['floor'];
//$comment = $_REQUEST['comment'];


//$insert_sql = "INSERT INTO users (first_name, last_name, email, facebook)" .
//"VALUES('{$first_name}', '{$last_name}', '{$email}', '{$facebook}');";
//mysql_query($insert_sql);
$mysqli = mysqli_connect("localhost", "root", "", "users");
$data = $_POST;

if (isset($data["submit"])) {
    $name = mysqli_real_escape_string($mysqli, trim($_POST["name"]));
    $email = mysqli_real_escape_string($mysqli, trim($_POST["email"]));
    $phone = mysqli_real_escape_string($connection, trim($_POST["phone"]));
    $street = mysqli_real_escape_string($mysqli, trim($_POST["street"]));
    $home = mysqli_real_escape_string($mysqli, trim($_POST["home"]));
    $part = mysqli_real_escape_string($mysqli, trim($_POST["part"]));
    $appt = mysqli_real_escape_string($mysqli, trim($_POST["appt"]));
    $floor = mysqli_real_escape_string($mysqli, trim($_POST["floor"]));
    $comment = mysqli_real_escape_string($mysqli, trim($_POST["comment"]));
    $errors = array();

    if (trim($data["name"]) == "") {
        $errors[] = "Введите ваше имя!";
    }

    if (trim($data["email"]) == "") {
        $errors[] = "Введите email!";
    }

    if (trim($data["phone"]) == "") {
        $errors[] = "Введите ваш номер телефона";
    }

    if (trim($data["street"]) == "") {
        $errors[] = "Введите Ваш адрес!";
    }

    if (trim($data["home"]) == "") {
        $errors[] = "Введите номер дома!";
    }

    if (trim($data["part"]) == "") {
        $errors[] = "Введите номер корпуса";
    }

    if (trim($data["appt"]) == "") {
        $errors[] = "Введите вномер крвартиры";
    }

    if (trim($data["floor"]) == "") {
        $errors[] = "Введите номер этажа";

        if (empty ($errors)) {

        } else {
            echo "<div style='color: #FF1830;'>" . array_shift($errors) . "</div>";
        }

        if (!empty($name) && !empty($email) && !empty($phone)) {
            $query = "SELECT * FROM login WHERE Name='$name'";
            $records = mysqli_query($connection, $query);
            if (mysqli_num_rows($records) == 0) {
                mysqli_query($connection, "INSERT INTO login (id,Name,Phone, Email ) VALUES (NULL, '$name','$phone', '$email')");
            }
            if (!empty($name) && !empty($email) && !empty($phone) && !empty($street) && !empty($home) && !empty($part) && !empty($appt) && !empty($floor) && !empty($comment)) {
                $query = "SELECT * FROM `order` WHERE `street`='$street'";
                $asd = mysqli_query($mysqli, $query);
                if (!$asd) {
                    printf("Errormessage: %s\n", $mysqli->error);
                    if (mysqli_num_rows($asd) == 0) {
                        mysqli_query($mysqli, "INSERT INTO `order` (`id`, `name`,`email`,`phone`,`street`,`hous`,`housing`,`flat`,`floor`,`comment`)
VALUES (NULL, '$name', '$email','$phone','$street','$home','$part','$appt','$floor','$comment')");
                        echo "<div style='color: #1854FF;'>Ваш заказ принят!</div>";
                        $message = "Ваш заказ - DarkBeefBurger за 500 рублей будет доставлен по адресу: $street дом $home, корпус $part, квартира $appt, $floor этаж.  \r\n
 Спасибо - это ваш первый заказ!";
                        $to = $email;
                        $subject = "Номер вашего заказа " . uniqid();
                        mail($to, $subject, $message);
                        mysqli_close($mysqli);
                        exit ();
                    } else {
                        echo " ";
                    }
                }
            }
        }
    }
}
?>
