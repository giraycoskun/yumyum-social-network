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
elseif(isset($_GET['post']))
{
    header("Location: post.php?id=$postID");
}
elseif(isset($_GET['profile']))
{
    header("Location: profile.php&id=$userID");
}
elseif(isset($_GET['search']))
{
    header("Location: search.php");
}
else
{
    header("Location: feed.php?id=$sessionID");
}
    
?>