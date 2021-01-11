<?php
include_once 'components/session.php';
require_once 'db/conn.php';

$userID = $_SESSION['uID'];


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['back'])){
        header("Location: profile.php?id=$userID");
    }
    else
    {
        $mail = trim($_POST['mail']);
        $pass = trim($_POST['password']);
        $uname = trim($_POST['username']);
        $age = strtolower(trim($_POST['age']));
        $bio = trim($_POST['bio']);
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);

        
        $check = 0;
        if($mail == "" or $pass=="" or $uname == "")
        {
            $result = false;
            $check = 1;
        }
        else
        {
            $result = $crud->updateUser($userID, $uname ,$pass, $fname, $mail, $lname, $bio, $age, $sex);
            $check = 2;

        }        
        if(!$result){
            if($check==1)
            {
                echo '<div class="alert alert-danger">Fields are Empty or Username</div>';
            }
            else
            {
                echo '<div class="alert alert-danger">Username is already used!!</div>';
            }
        }
        else
        {
            $orig_file = $_FILES["photo"]["tmp_name"];
            $ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            $target_dir = 'files/users/';
            $destination = "$target_dir$userID.$ext";
            move_uploaded_file($orig_file,$destination);
            
            $result = $crud->getUser($mail, $pass);

            $_SESSION['mail'] = $result['mail'];
            $_SESSION['uID'] = $result['uID'];
            $_SESSION['isAdmin'] = $result['isAdmin'];
        }

        header("Location: profile.php?id=$userID");
    }
}
else
{
    header("Location: profile.php?id=$userID");
}
?>