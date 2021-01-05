<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php'

?>



<p>Welcome to Admin DashBoard <?php echo $_SESSION['mail']." - ".$_SESSION['uID'] ?></p>


<?php require_once 'components/footer.php'; ?>