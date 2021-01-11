<?php

include_once 'components/session.php';
require_once 'db/conn.php';

$postID = $_GET['pid'];
$userID = $_GET['id'];
$sessionID = $_SESSION['uID'];
$action = $_GET['action'];
$content = $_POST['content'];


$crud->insertComment($sessionID, $postID, $content);


if($action == "feed")
{
    header("Location: feed.php?id=$sessionID");
}
elseif($action == "profile")
{
    header("Location: profile.php?id=$userID");
}
elseif($action == "post")
{
    header("Location: post.php?id=$postID");
}
elseif($action== 'search')
{
    header("Location: search.php");
}
else
{
    header("Location: feed.php?id=$sessionID");
}

    
?>