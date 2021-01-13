<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php'; 
require_once 'db/conn.php';

$userID = $_GET['id'];

#$action = $_GET['action'];
#echo "User ID: ".$userID;
#echo " Session ID: ".$_SESSION['uID'];
if ($userID == $_SESSION['uID']) {
  $checkUser = true;
} else {
  $checkUser = false;
}
?>


<div class="container">
<h1>Welcome to Notifications Page</h1>

<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Notification</th>
        <?php if ($checkUser) : ?>
        <th scope="col">Delete</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php $resultNotif = $crud->getAllNotifications($userID);
    $count = 0;
    foreach ($resultNotif as $index => $notifContex) {
        $count = $count + 1; ?>
        <tr>
        <th scope="row"><?php echo $count ?></th>
        <td><?php echo $notifContex['content'] ?></td>
        <?php if ($checkUser) : ?>
            <td><a class="btn btn-danger" role="button" href="deleteNotification.php?id=<?php echo $notifContex['nID']?>&uID= <?php echo $userID?>" > Delete </a></td>
        <?php endif; ?>
        </tr>
    <?php } ?>
    
    </tbody>
</table>
</div>



<?php require_once 'components/footer.php'; ?>