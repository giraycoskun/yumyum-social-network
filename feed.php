<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];
echo "User ID: ".$userID;
echo " Session ID: ".$_SESSION['uID'];

?>

<h1>Welcome to Home</h1>



<?php require_once 'components/footer.php'; ?>