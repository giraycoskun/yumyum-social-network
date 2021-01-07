<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];

$action = $_GET['action'];
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

<?php if ($action == "follower"): ?>

<div class="container">
<h1>Welcome to Follower List</h1>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Follower</th>
    </tr>
  </thead>
  <tbody>
  <?php $resultFollowers = $crud->getFollowers($userID);
  $count = 0;
  foreach( $resultFollowers as $index => $follower ) {$count = $count + 1;?>
    <tr>
      <th scope="row"><?php echo $count?></th>
      <td><?php echo $follower['uName']?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</div>

<?php elseif ($action == "following"): ?>

    <div class="container">
<h1>Welcome to Following List</h1>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Following</th>
    </tr>
  </thead>
  <tbody>
  <?php $resultFollowering = $crud->getFollowing($userID);
  $count = 0;
  foreach( $resultFollowering as $index => $followee ) {$count = $count + 1;?>
    <tr>
      <th scope="row"><?php echo $count?></th>
      <td><?php echo $followee['uName']?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</div>

<?php elseif ($action == "showlocs"): ?>

<div class="container">
<h1>Welcome to Locations List</h1>

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
      <?php $locations = $crud->getFollowedLocations($userID);
      $count = 0;
      foreach( $locations as $loc ) {$count = $count + 1;?>
      <tr>
        <th scope="row"><?php echo $count?></th>
        <td><?php echo $loc['locName']?></td>
        <?php if ($checkUser): ?>
        <td><a class="btn btn-danger" role="button" href="following.php?id=<?php echo $loc['locID']?>&action=loc">Unfollow</a></td>
        <?php endif; ?>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>

<?php else: header("Location: profile.php?id=$userID")?>

<?php endif; ?>


<?php require_once 'components/footer.php'; ?>