<?php

include_once 'components/session.php';
require_once 'db/conn.php';


$ID = $_GET['id'];
$sessionID = $_SESSION['uID'];

$action = $_GET['action'];

if($action == "follow")
{
    $crud->followUser($ID, $sessionID);
}
else if($action == "unfollow")
{
    $crud->unfollowUser($ID, $sessionID);
}
else if($action == "loc")
{
    $crud->unfollowLoc($ID, $sessionID);
    #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
    header("Location: showFollow.php?id=$sessionID&action=showlocs");
}

else if($action == "tags")
{
    $crud->unfollowTag($ID, $sessionID);
    #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
    header("Location: showTags.php?id=$sessionID&action=tags");
}




header("Location: profile.php?id=$ID");

?>



