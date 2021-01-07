<?php

include_once 'components/session.php';
require_once 'db/conn.php';


$userID = $_GET['id'];
$sessionID = $_SESSION['uID'];

$crud->reportUser($userID);

header("Location: profile.php?id=$userID");

?>