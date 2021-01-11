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
        $postID = $_POST['postID'];
        $content = $_POST['content'];;

        $crud->updatePostTxt($postID, $content);
        header("Location: profile.php?id=$userID");
    }
}
else
{
    header("Location: profile.php?id=$userID");
}



?>