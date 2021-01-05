<?php 
$title = 'Yum-Yum Home';
require_once 'components/header.php'; 

if (isset($_POST['sign'])) {
    header('Location: user.php');
} else if (isset($_POST['register'])) {
    header('Location: register.php');
} else {
    //no button pressed
    header('Location: index.php');
}

?>






<?php require_once 'components/footer.php'; ?>