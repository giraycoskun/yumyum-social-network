<?php

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];
if ($userID != $_SESSION['uID']) {
    header("Location: logout.php");
}
$sessionID = $_SESSION['uID'];


if(isset($_POST['delete']))
{
    $crud->deleteUser($userID);
    echo '<div class="alert alert-danger">Checkpoint-1</div>';
    header("Location: logout.php");
}
else if(isset($_POST['submit']))
{   
    $date = $_POST['date'];
    $crud->deactivateUser($userID, $date);
    echo '<div class="alert alert-danger">Checkpoint-1</div>';
    header("Location: logout.php");
}
else if(isset($_POST['close']))
{
    echo '<div class="alert alert-danger">Checkpoint-1</div>';
    header("Location: profile.php?id=$sessionID");
}

?>
<?php require_once 'components/footer.php'; ?>