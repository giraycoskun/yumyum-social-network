<?php
include_once 'components/session.php';
require_once 'db/conn.php';

$userID = $_SESSION['uID'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $message = $_POST['message'];
    $responseID = $_POST['responseID'];
    $crud->insertMessages($userID, $responseID, $message);
    header("Location: chatbox.php?id=$userID");    
}
else if(isset($_GET['delete']))
{
    $responseID = $_GET['id'];
    $crud->deleteChat($userID, $responseID);
    header("Location: chatbox.php?id=$userID");
}
else
{
    header("Location: chatbox.php?id=$userID");
}

?>