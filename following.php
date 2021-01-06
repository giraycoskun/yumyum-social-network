<?php

include_once 'components/session.php';
require_once 'db/conn.php';


$userID = $_GET['id'];
$sessionID = $_SESSION['uID'];

$action = $_GET['action'];

if($action == "follow")
{
    $crud->follow($userID, $sessionID);
}
else
{
    $crud->unfollow($userID, $sessionID);
}

header("Location: profile.php?id=$userID");

?>



