<?php

include_once 'components/session.php';
require_once 'db/conn.php';

$postID = $_GET['pid'];
$userID = $_GET['id'];
$sessionID = $_SESSION['uID'];
$action = $_GET['action'];


if($action == "like")
{
    $crud->likePost($sessionID, $postID);
    echo '<div class="alert alert-danger">Checkpoint 2 </div>';
    
}
elseif($action == "dislike")
{
    $crud->dislikePost($sessionID, $postID);
    echo '<div class="alert alert-danger">Checkpoint 2 </div>';
}

if(isset($_GET['feed']))
{
    header("Location: feed.php?id=$sessionID");
}
else
{
    header("Location: profile.php?id=$userID");
}
    
?>