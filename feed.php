<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php'

?>



<p>Welcome to Your Feed <?php echo $_SESSION['mail']?></p>

<?php require_once 'components/footer.php'; ?>