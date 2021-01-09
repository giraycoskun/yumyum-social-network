<?php

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php'

?>



<p>Welcome to Admin DashBoard <?php echo $_SESSION['mail'] . " - " . $_SESSION['uID'] ?></p>
<br> <br>

<div class="container">
  <div class="row">
    <div class="col-12">
      <p class="lead">Reported Users</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $results = $crud->getReportedUsers();
          while ($row = $results->fetch(PDO::FETCH_ASSOC)) { ?>

            <tr>
              <td><?php echo $row['uID'] ?></td>
              <td><?php echo $row['uName'] ?></td>
              <td>
                <form action="suspendUser.php?id=<?php echo $row['uID'] ?>" method="POST">
                  <a href="profile.php?id=<?php echo $row['uID'] ?>" class="btn btn-primary">View</a>

                  <input type="text" id="day" name="day" placeholder="How many days?" required>
                  <button class="btn btn-warning" type="submit">Suspend</button>

                  <a onclick="return confirm('Are you sure you want to delete this user?');" href="deleteUser.php?id=<?php echo $row['uID'] ?>" class="btn btn-danger">Delete</a>
                  <a href="deleteUserReport.php?id=<?php echo $row['uID'] ?>" class="btn btn-success">Delete Report</a>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-12">
      <p class="lead">Banned Users</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Banned Until</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $results = $crud->getBannedUsers();
          while ($row = $results->fetch(PDO::FETCH_ASSOC)) { ?>

            <tr>
              <td><?php echo $row['uID'] ?></td>
              <td><?php echo $row['uName'] ?></td>
              <td><?php echo $row['bannedUntil'] ?></td>
              <td>
                <form action="unsuspendUser.php?id=<?php echo $row['uID'] ?>" method="POST">
                  <a href="profile.php?id=<?php echo $row['uID'] ?>" class="btn btn-primary">View</a>
                  <button class="btn btn-warning" type="submit">unSuspend</button>
                  <a onclick="return confirm('Are you sure you want to delete this user?');" href="deleteUser.php?id=<?php echo $row['uID'] ?>" class="btn btn-danger">Delete</a>
                  <a href="deleteUserReport.php?id=<?php echo $row['uID'] ?>" class="btn btn-success">Delete Report</a>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-12">
      <p class="lead">Reported Posts</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">Post ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $results = $crud->getReportedPosts();
          while ($row = $results->fetch(PDO::FETCH_ASSOC)) { ?>

            <tr>
              <td><?php echo $row['uID'] ?></td>
              <td><?php echo $row['pID'] ?></td>
              <td><?php echo $row['uName'] ?></td>
              <td>
                <a href="post.php?id=<?php echo $row['pID'] ?>" class="btn btn-primary">View</a>
                <a href="hidePost.php?id=<?php echo $row['pID'] ?>" class="btn btn-warning">Hide</a>

                <a onclick="return confirm('Are you sure you want to delete this post?');" href="deletePost.php?id=<?php echo $row['pID'] ?>" class="btn btn-danger">Delete</a>
                <a onclick="return confirm('Are you sure you want to delete this report?');" href="deletePostReport.php?id=<?php echo $row['pID'] ?>" class="btn btn-success">Delete Report</a>
              </td>
            </tr>
          <?php } ?>



        </tbody>
      </table>
    </div>

  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-12">
      <p class="lead">Hidden Posts</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">Post ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $results = $crud->getHiddenPosts();
          while ($row = $results->fetch(PDO::FETCH_ASSOC)) { ?>

            <tr>
              <td><?php echo $row['uID'] ?></td>
              <td><?php echo $row['pID'] ?></td>
              <td><?php echo $row['uName'] ?></td>
              <td>
                <a href="post.php?id=<?php echo $row['pID'] ?>" class="btn btn-primary">View</a>
                <a href="unhidePost.php?id=<?php echo $row['pID'] ?>" class="btn btn-warning">Unhide</a>
                <a onclick="return confirm('Are you sure you want to delete this post?');" href="deletePost.php?id=<?php echo $row['pID'] ?>" class="btn btn-danger">Delete</a>
                <a onclick="return confirm('Are you sure you want to delete this report?');" href="deletePostReport.php?id=<?php echo $row['pID'] ?>" class="btn btn-success">It's safe</a>
              </td>
            </tr>
          <?php } ?>



        </tbody>
      </table>
    </div>

  </div>
</div>


<?php require_once 'components/footer.php'; ?>