<?php

include_once 'components/session.php';
require_once 'db/conn.php';




if(isset($_GET['pid']))
{
    $postID = $_GET['pid'];
    $userID = $_GET['id'];
    $crud->reportPost($postID);
    header("Location: profile.php?id=$userID");
}
else
{
    $userID = $_GET['id'];
    $crud->reportUser($userID);
    header("Location: profile.php?id=$userID");
}
?>