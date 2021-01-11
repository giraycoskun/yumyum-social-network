<?php
include_once 'components/session.php';
require_once 'db/conn.php';

$userID = $_SESSION['uID'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['back'])) {
        header("Location: profile.php?id=$userID");
    } else {
        
        #TODO

        header("Location: profile.php?id=$userID");
    }
} else {
    header("Location: profile.php?id=$userID");
}
