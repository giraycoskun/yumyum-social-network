<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];
$action =  "tags";
#echo "User ID: ".$userID;
#echo " Session ID: ".$_SESSION['uID'];
if($userID == $_SESSION['uID'])
{
  $checkUser = true;
}
else
{
  $checkUser = false;
}

?>

<?php if($action = "tags"):?>

<div class="container">
<h1>Welcome to Tags List</h1>

  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Tags</th>
        <?php if ($checkUser): ?>
        <th scope="col">Unfollow</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php $tags = $crud->getFollowedTags($userID);
      $count = 0;
      foreach( $tags as $tag ) {$count = $count + 1;?>
      <tr>
        <th scope="row"><?php echo $count?></th>
        <td><?php echo $tag['tagName']?></td>
        <?php if ($checkUser): ?>
        <td><a class="btn btn-danger" role="button" href="following.php?id=<?php echo $tag['tagID']?>&action=tags">Unfollow</a></td>
        <?php endif; ?>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>

<?php endif;?>





<?php require_once 'components/footer.php'; ?>