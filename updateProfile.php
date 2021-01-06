<?php
include_once 'components/session.php';
require_once 'db/conn.php';




if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['back'])){
        header('Location: profile.php');
    }
    else
    {
        echo "update profile";
    }
    

    #header('Location: profile.php');
}



?>