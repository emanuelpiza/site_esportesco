<?php

session_start();
ob_start();
include('dbcon/dbcon.php');

if (isset($_POST['path'])) {
    $video_path = $_POST['path'];

    $query = "INSERT INTO video VALUES(null,'$video_path')";
    if (mysql_query($query)) {
        $_SESSION["vs"] = "Update successfully ";
        header("Location: admin.php");
    } else {
        $_SESSION["ver"] = "Update Fail ";
        header("Location: admin.php");
    }

    echo 'Successfully select File ';
}

if (isset($_POST['change'])) {

    $sqlpw = mysql_query("SELECT * FROM user WHERE sysstate='admin'");

    while ($data = mysql_fetch_assoc($sqlpw)) {
        if ($_POST['olpw'] == $data['password']) {

            if ($_POST['newpw'] == $_POST['cnpw']) {
                $pw = $_POST['newpw'];
                if (mysql_query("UPDATE user SET password=$pw WHERE sysstate='admin'")) {
                    $_SESSION["nps"] = "Update successfully ";
                    header("Location: admin.php");
                } else {
                    $_SESSION["nper"] = "Update fail ";
                    header("Location: admin.php");
                }
            } else {
                $_SESSION["npcer"] = "Password confirmation fail ";
                header("Location: admin.php");
            }
        }
    }
}




if (isset($_POST['upload'])) {

    $target_dir = "../img/upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $_SESSION["upload"] = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $_SESSION["upload"] = "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
         $_SESSION["upload"] = "Sorry, file already exists.";
        $uploadOk = 0;
       
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      $_SESSION["upload"] = "Sorry, your file is too large.";
        $uploadOk = 0;
          
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
       $_SESSION["upload"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
          
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header("Location: admin.php");
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            $head = $_POST['head'];
            $dis = $_POST['dis'];
            $path = 'img/upload/' . $_FILES["fileToUpload"]["name"];
            $date = $_POST['date'];

            if (mysql_query("INSERT INTO whatnew VALUES(null,'$head','$dis','$path','$date')")) {
                $_SESSION["uploadok"] = "The file  has been uploaded.";
                 header("Location: admin.php");
            }
        } else {
             $_SESSION["upload"] = "The file uploaded. Fail";
              header("Location: admin.php");
        }
    }
}
